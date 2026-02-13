<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainPanelController extends Controller
{
    public function index()
    {
        return view('main-panel');
    }

    public function dashboard()
    {
        return view('main-panel.dashboard');
    }

    public function petRegistration()
    {
        return view('main-panel.pet-registration.index');
    }

    public function registerPet()
    {
        return view('main-panel.pet-registration.register');
    }

    public function listPets()
    {
        return view('main-panel.pet-registration.list');
    }

    public function petCategories()
    {
        return view('main-panel.pet-registration.categories');
    }

    public function bookings()
    {
        return view('main-panel.bookings.index');
    }

    public function createBooking()
    {
        return view('main-panel.bookings.create');
    }

    public function opd()
    {
        return view('main-panel.opd.index');
    }

    public function createOPD()
    {
        return view('main-panel.opd.create');
    }

    public function listOPD()
    {
        return view('main-panel.opd.list');
    }

    public function ward()
    {
        return view('main-panel.ward.index');
    }

    public function salon()
    {
        return view('main-panel.salon.index');
    }

    public function createSalon()
    {
        return view('main-panel.salon.create');
    }

    public function listSalon()
    {
        return view('main-panel.salon.list');
    }

    public function pharmacy()
    {
        return view('main-panel.pharmacy.index');
    }

    public function pharmacyPOS()
    {
        return view('main-panel.pharmacy.pos');
    }

    public function pharmacyInventory()
    {
        return view('main-panel.stock.pharmacy');
    }

    public function stock()
    {
        return view('main-panel.stock.index');
    }

    public function stockPharmacy()
    {
        return view('main-panel.stock.pharmacy');
    }

    public function stockOPD()
    {
        return view('main-panel.stock.opd');
    }

    public function stockMain()
    {
        return view('main-panel.stock.main');
    }

    public function supplierMgmt()
    {
        return view('main-panel.supplier-mgmt.index');
    }

    public function expenses()
    {
        return view('main-panel.expenses.index');
    }

    public function createExpense()
    {
        return view('main-panel.expenses.create');
    }

    public function listExpenses()
    {
        return view('main-panel.expenses.list');
    }

    public function createExpenseCategory()
    {
        return view('main-panel.expenses.category-create');
    }

    public function listExpenseCategories()
    {
        return view('main-panel.expenses.category-list');
    }

    public function finalBilling()
    {
        return view('main-panel.final-billing.index');
    }

    public function users()
    {
        return view('main-panel.users.index');
    }

    public function usersAttendance()
    {
        return view('main-panel.users.attendance');
    }

    public function usersPayroll()
    {
        return view('main-panel.users.payroll');
    }

    public function createUser()
    {
        return view('main-panel.users.create');
    }

    public function listUsers()
    {
        return view('main-panel.users.list');
    }






    // Add more methods as needed
}
