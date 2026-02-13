<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        return view('main-panel.pages.pet-registration.register');
    }

    public function listPets()
    {
        return view('main-panel.pages.pet-registration.list');
    }

    public function petCategories()
    {
        return view('main-panel.pages.pet-registration.categories');
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
        return view('main-panel.pages.opd.create');
    }

    public function listOPD()
    {
        return view('main-panel.pages.opd.list');
    }

    public function ward()
    {
        return view('main-panel.pages.ward.index');
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
