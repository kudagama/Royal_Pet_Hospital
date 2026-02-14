<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PetCategory;
use App\Models\PetBreed;
use App\Models\Pet;
use App\Models\OpdVisit;
use App\Models\OpdService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class MainPanelController extends Controller
{
    public function index()
    {
        return view('main-panel.pages.index');
    }

    public function dashboard()
    {
        return view('main-panel.pages.dashboard');
    }

    public function petRegistration()
    {
        return view('main-panel.pages.pet-registration.index');
    }

    public function registerPet()
    {
        $categories = PetCategory::where('is_active', true)->with('breeds')->get();
        return view('main-panel.pages.pet-registration.register', compact('categories'));
    }

    public function storePet(Request $request)
    {
        $request->validate([
            'pet_name' => 'required|string|max:255',
            'owner_name' => 'required|string|max:255',
            'owner_phone' => 'nullable|string|max:20',
            'pet_age' => 'required|numeric|min:0',
            'pet_category_id' => 'required|exists:pet_categories,id',
            'pet_breed_id' => 'required|exists:pet_breeds,id',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        // Generate Code
        $lastPet = Pet::latest()->first();
        $nextId = $lastPet ? $lastPet->id + 1 : 1;
        $code = 'RP' . str_pad($nextId, 5, '0', STR_PAD_LEFT);

        // Handle Image
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('pets', 'public');
        }

        // Calculate DOB
        $months = (int)($request->pet_age * 12);
        $dob = now()->subMonths($months);

        Pet::create([
            'code' => $code,
            'name' => $request->pet_name,
            'owner_name' => $request->owner_name,
            'owner_phone' => $request->owner_phone,
            'date_of_birth' => $dob,
            'pet_category_id' => $request->pet_category_id,
            'pet_breed_id' => $request->pet_breed_id,
            'description' => $request->description,
            'image' => $imagePath,
        ]);

        return redirect()->route('pet-registration.register')->with('success', 'Pet registered successfully! Code: ' . $code);
    }

    public function listPets()
    {
        $pets = Pet::with('breed')->latest()->get();
        return view('main-panel.pages.pet-registration.list', compact('pets'));
    }

    public function editPet($id)
    {
        $pet = Pet::findOrFail($id);
        $categories = PetCategory::where('is_active', true)->with('breeds')->get();
        return view('main-panel.pages.pet-registration.edit', compact('pet', 'categories'));
    }

    public function updatePet(Request $request, $id)
    {
        $request->validate([
            'pet_name' => 'required|string|max:255',
            'owner_name' => 'required|string|max:255',
            'owner_phone' => 'nullable|string|max:20',
            'pet_age' => 'required|numeric|min:0',
            'pet_category_id' => 'required|exists:pet_categories,id',
            'pet_breed_id' => 'required|exists:pet_breeds,id',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $pet = Pet::findOrFail($id);

        $data = [
            'name' => $request->pet_name,
            'owner_name' => $request->owner_name,
            'owner_phone' => $request->owner_phone,
            'pet_category_id' => $request->pet_category_id,
            'pet_breed_id' => $request->pet_breed_id,
            'description' => $request->description,
        ];

        // Recalculate DOB if age changed (basic approach, ideally store DOB directly)
        $months = (int)($request->pet_age * 12);
        // We only update DOB if we are assuming age was exact input, but here let's just update it based on current time
        // Or keep original DOB if age matches year diff? For simplicity let's re-calc DOB based on input age
        $data['date_of_birth'] = now()->subMonths($months);


        if ($request->hasFile('image')) {
            if ($pet->image) {
                Storage::cloud()->delete($pet->image); // Or Storage::disk('public')->delete(...)
                Storage::delete('public/' . $pet->image);
            }
            $data['image'] = $request->file('image')->store('pets', 'public');
        }

        $pet->update($data);

        return redirect()->route('pet-registration.list')->with('success', 'Pet updated successfully!');
    }

    public function showPet($id)
    {
        $pet = Pet::with(['category', 'breed'])->findOrFail($id);
        return view('main-panel.pages.pet-registration.profile', compact('pet'));
    }

    public function petCategories()
    {
        $categories = PetCategory::with('breeds')->get();
        return view('main-panel.pages.pet-registration.categories', compact('categories'));
    }

    public function storePetCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:10',
        ]);

        PetCategory::create($request->all());

        return redirect()->route('pet-registration.categories')->with('success', 'Category added successfully!');
    }

    public function editPetCategory($id)
    {
        $category = PetCategory::findOrFail($id);
        return response()->json($category);
    }

    public function updatePetCategory(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:10',
        ]);

        $category = PetCategory::findOrFail($id);
        $category->update($request->all());

        return redirect()->route('pet-registration.categories')->with('success', 'Category updated successfully!');
    }

    public function deletePetCategory($id)
    {
        $category = PetCategory::findOrFail($id);
        $category->delete();

        return redirect()->route('pet-registration.categories')->with('success', 'Category deleted successfully!');
    }

    public function togglePetCategoryStatus($id)
    {
        $category = PetCategory::findOrFail($id);
        $category->is_active = !$category->is_active;
        $category->save();

        return redirect()->route('pet-registration.categories')->with('success', 'Category status updated successfully!');
    }

    public function storePetBreed(Request $request)
    {
        $request->validate([
            'pet_category_id' => 'required|exists:pet_categories,id',
            'name' => 'required|string|max:255',
        ]);

        PetBreed::create($request->all());

        return redirect()->back()->with('success', 'Breed added successfully!');
    }

    public function deletePetBreed($id)
    {
        $breed = PetBreed::findOrFail($id);
        $breed->delete();

        return redirect()->back()->with('success', 'Breed deleted successfully!');
    }

    public function bookings()
    {
        return view('main-panel.pages.bookings.index');
    }

    public function createBooking()
    {
        return view('main-panel.pages.bookings.create');
    }

    public function opd()
    {
        return view('main-panel.pages.opd.index');
    }

    public function createOPD()
    {
        $pets = Pet::select('id', 'name', 'code', 'owner_name')->get();
        return view('main-panel.pages.opd.create', compact('pets'));
    }

    public function storeOPD(Request $request)
    {
        $request->validate([
            'pet_id' => 'required|exists:pets,id',
            'visit_date' => 'required|date',
            'services' => 'required|array|min:1',
            'services.*.title' => 'required|string',
            'services.*.price' => 'required|numeric|min:0',
            'services.*.description' => 'nullable|string',
            // touchPanelImage is optional and handled as string (base64)
        ]);

        DB::beginTransaction();

        try {
            // Generate Code
            $lastVisit = OpdVisit::latest()->first();
            $nextId = $lastVisit ? $lastVisit->id + 1 : 1;
            $visitRef = 'OPD' . str_pad($nextId, 5, '0', STR_PAD_LEFT);

            $totalAmount = collect($request->services)->sum('price');

            $visit = OpdVisit::create([
                'visit_ref' => $visitRef,
                'pet_id' => $request->pet_id,
                'visit_date' => $request->visit_date,
                'total_amount' => $totalAmount,
                'status' => 'pending',
            ]);

            foreach ($request->services as $service) {
                OpdService::create([
                    'opd_visit_id' => $visit->id,
                    'service_title' => $service['title'],
                    'price' => $service['price'],
                    'description' => $service['description'] ?? null,
                    'touch_panel_image' => $service['touchPanelImage'] ?? null,
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'OPD saved successfully',
                'entry' => $visit->load('services', 'pet')
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error saving OPD: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updateOPDAdvance(Request $request, $id)
    {
        $request->validate([
            'advance_amount' => 'required|numeric|min:0',
        ]);

        $visit = OpdVisit::findOrFail($id);
        $visit->update([
            'advance_amount' => $request->advance_amount,
            // Status might change? Maybe 'billed' or 'partial'? Let's keep pending or change to 'billed' if full?
            // For now just update amount.
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Advance updated successfully',
        ]);
    }

    public function listOPD()
    {
        $opdVisits = OpdVisit::with('pet', 'services')->latest()->get();
        return view('main-panel.pages.opd.list', compact('opdVisits'));
    }

    public function showOPDDetails($id)
    {
        $visit = OpdVisit::with(['pet', 'services'])->findOrFail($id);
        return response()->json($visit);
    }

    public function ward()
    {
        $pets = \App\Models\Pet::select('id', 'name', 'code')->get();
        return view('main-panel.pages.ward.index', compact('pets'));
    }

    public function salon()
    {
        return view('main-panel.pages.salon.index');
    }

    public function createSalon()
    {
        return view('main-panel.pages.salon.create');
    }

    public function listSalon()
    {
        return view('main-panel.pages.salon.list');
    }

    public function pharmacy()
    {
        return view('main-panel.pages.pharmacy.index');
    }

    public function pharmacyPOS()
    {
        return view('main-panel.pages.pharmacy.pos');
    }

    public function pharmacyInventory()
    {
        return view('main-panel.pages.stock.pharmacy');
    }

    public function stock()
    {
        return view('main-panel.pages.stock.index');
    }

    public function stockPharmacy()
    {
        return view('main-panel.pages.stock.pharmacy');
    }

    public function stockOPD()
    {
        return view('main-panel.pages.stock.opd');
    }

    public function stockMain()
    {
        return view('main-panel.pages.stock.main');
    }

    public function supplierMgmt()
    {
        return view('main-panel.pages.supplier-mgmt.index');
    }

    public function expenses()
    {
        return view('main-panel.pages.expenses.index');
    }

    public function createExpense()
    {
        return view('main-panel.pages.expenses.create');
    }

    public function listExpenses()
    {
        return view('main-panel.pages.expenses.list');
    }

    public function createExpenseCategory()
    {
        return view('main-panel.pages.expenses.category-create');
    }

    public function listExpenseCategories()
    {
        return view('main-panel.pages.expenses.category-list');
    }

    public function finalBilling()
    {
        return view('main-panel.pages.final-billing.index');
    }

    public function users()
    {
        return view('main-panel.pages.users.index');
    }

    public function usersAttendance()
    {
        return view('main-panel.pages.users.attendance');
    }

    public function usersPayroll()
    {
        return view('main-panel.pages.users.payroll');
    }

    public function createUser()
    {
        return view('main-panel.pages.users.create');
    }

    public function listUsers()
    {
        return view('main-panel.pages.users.list');
    }






    // Add more methods as needed
}
