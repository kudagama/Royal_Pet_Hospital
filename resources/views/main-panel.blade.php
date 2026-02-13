@extends('layouts.main')

@section('title', 'Application | Main Panel')

@section('content')
<div class="flex-grow flex items-center justify-center w-full">
    <!--Main Panel (for max-lg)-->
    <div class="flex flex-wrap justify-center gap-6 w-full h-fit py-6 text-white page-padding">
        <!-- 0. Dashboard -->
        <div onclick="locatePanelItem('dashboard');"
            class="w-[250px] max-lg:w-[200px] h-[200px] max-lg:h-[150px] text-white uppercase lg:text-xl transform transition-all duration-300 ease-in-out hover:translate-y-[-10px] hover:scale-[1.02] hover:rotate-[1deg] cardBox cursor-pointer">
            <div class="card">
                <img src="{{ asset('images/main-panel/btn-icons/dash.svg') }}"
                    class="w-[105px] h-[105px] max-xl:w-[70px] max-xl:h-[70px]" alt="">
                <p class="text-center">Dashboard</p>
            </div>
        </div>

        <!-- 1. Pet Registration -->
        <div onclick="locatePanelItem('petRegistretion');"
            class="w-[250px] max-lg:w-[200px] h-[200px] max-lg:h-[150px] text-white uppercase lg:text-xl transform transition-all duration-300 ease-in-out hover:translate-y-[-10px] hover:scale-[1.02] hover:rotate-[1deg] cardBox cursor-pointer">
            <div class="card">
                <img src="{{ asset('images/main-panel/btn-icons/animal.png') }}"
                    class="w-[105px] h-[105px] max-xl:w-[70px] max-xl:h-[70px]" alt="">
                <p class="text-center">Pet Management</p>
            </div>
        </div>

        <!-- 2. Booking List View -->
        <div onclick="locatePanelItem('bookings');"
            class="w-[250px] max-lg:w-[200px] h-[200px] max-lg:h-[150px] text-white uppercase lg:text-xl transform transition-all duration-300 ease-in-out hover:translate-y-[-10px] hover:scale-[1.02] hover:rotate-[1deg] cardBox cursor-pointer">
            <div class="card">
                <img src="{{ asset('images/main-panel/btn-icons/calendar.png') }}"
                    class="w-[105px] h-[105px] max-xl:w-[70px] max-xl:h-[70px]" alt="">
                <p class="text-center">Booking List</p>
            </div>
        </div>


        <!-- 3. OPD -->
        <div onclick="locatePanelItem('opd');"
            class="w-[250px] max-lg:w-[200px] h-[200px] max-lg:h-[150px] text-white uppercase lg:text-xl transform transition-all duration-300 ease-in-out hover:translate-y-[-10px] hover:scale-[1.02] hover:rotate-[1deg] cardBox cursor-pointer">
            <div class="card">
                <img src="{{ asset('images/main-panel/btn-icons/customer.svg') }}"
                    class="w-[105px] h-[105px] max-xl:w-[70px] max-xl:h-[70px]" alt="">
                <p class="text-center">OPD</p>
            </div>
        </div>

        <!-- 5. Pet Hospital (Rooms) -->
        <div onclick="locatePanelItem('ward');"
            class="w-[250px] max-lg:w-[200px] h-[200px] max-lg:h-[150px] text-white uppercase lg:text-xl transform transition-all duration-300 ease-in-out hover:translate-y-[-10px] hover:scale-[1.02] hover:rotate-[1deg] cardBox cursor-pointer">
            <div class="card">
                <img src="{{ asset('images/main-panel/btn-icons/cat-house.png') }}"
                    class="w-[105px] h-[105px] max-xl:w-[70px] max-xl:h-[70px]" alt="">
                <p class="text-center">Pet Hostel</p>
            </div>
        </div>

        <!-- 6. Pet Salon -->
        <div onclick="locatePanelItem('salon');"
            class="w-[250px] max-lg:w-[200px] h-[200px] max-lg:h-[150px] text-white uppercase lg:text-xl transform transition-all duration-300 ease-in-out hover:translate-y-[-10px] hover:scale-[1.02] hover:rotate-[1deg] cardBox cursor-pointer">
            <div class="card">
                <img src="{{ asset('images/main-panel/btn-icons/items.svg') }}"
                    class="w-[105px] h-[105px] max-xl:w-[70px] max-xl:h-[70px]" alt="">
                <p class="text-center">Pet Salon</p>
            </div>
        </div>

        <!-- 7. Pharmacy & Pet Shop -->
        <div onclick="locatePanelItem('pharmacy');"
            class="w-[250px] max-lg:w-[200px] h-[200px] max-lg:h-[150px] text-white uppercase lg:text-xl transform transition-all duration-300 ease-in-out hover:translate-y-[-10px] hover:scale-[1.02] hover:rotate-[1deg] cardBox cursor-pointer">
            <div class="card">
                <img src="{{ asset('images/main-panel/btn-icons/sales.svg') }}"
                    class="w-[105px] h-[105px] max-xl:w-[70px] max-xl:h-[70px]" alt="">
                <p class="text-center">Pharmacy & Pet Shop</p>
            </div>
        </div>

        <!-- 8. Stock Management -->
        <div onclick="locatePanelItem('stock');"
            class="w-[250px] max-lg:w-[200px] h-[200px] max-lg:h-[150px] text-white uppercase lg:text-xl transform transition-all duration-300 ease-in-out hover:translate-y-[-10px] hover:scale-[1.02] hover:rotate-[1deg] cardBox cursor-pointer">
            <div class="card">
                <img src="{{ asset('images/main-panel/btn-icons/inventory-management.png') }}"
                    class="w-[105px] h-[105px] max-xl:w-[70px] max-xl:h-[70px]" alt="">
                <p class="text-center">Stock Management</p>
            </div>
        </div>

        <!-- 9. Suppliers -->
        <div onclick="locatePanelItem('supplier-mgmt');"
            class="w-[250px] max-lg:w-[200px] h-[200px] max-lg:h-[150px] text-white uppercase lg:text-xl transform transition-all duration-300 ease-in-out hover:translate-y-[-10px] hover:scale-[1.02] hover:rotate-[1deg] cardBox cursor-pointer">
            <div class="card">
                <img src="{{ asset('images/main-panel/btn-icons/supp-mgmt.png') }}"
                    class="w-[105px] h-[105px] max-xl:w-[70px] max-xl:h-[70px]" alt="">
                <p class="text-center">Suppliers</p>
            </div>
        </div>

        <!-- 10. Expenses -->
        <div onclick="locatePanelItem('expenses');"
            class="w-[250px] max-lg:w-[200px] h-[200px] max-lg:h-[150px] text-white uppercase lg:text-xl transform transition-all duration-300 ease-in-out hover:translate-y-[-10px] hover:scale-[1.02] hover:rotate-[1deg] cardBox cursor-pointer">
            <div class="card">
                <img src="{{ asset('images/main-panel/btn-icons/expenses.svg') }}"
                    class="w-[105px] h-[105px] max-xl:w-[70px] max-xl:h-[70px]" alt="">
                <p class="text-center">Expenses</p>
            </div>
        </div>

        <!-- 11. Final Billing -->
        <div onclick="locatePanelItem('final-billing');"
            class="w-[250px] max-lg:w-[200px] h-[200px] max-lg:h-[150px] text-white uppercase lg:text-xl transform transition-all duration-300 ease-in-out hover:translate-y-[-10px] hover:scale-[1.02] hover:rotate-[1deg] cardBox cursor-pointer">
            <div class="card">
                <img src="{{ asset('images/main-panel/btn-icons/billing.svg') }}"
                    class="w-[105px] h-[105px] max-xl:w-[70px] max-xl:h-[70px]" alt="">
                <p class="text-center">Final Billing</p>
            </div>
        </div>

        <!-- 12. Employee Management -->
        <div onclick="locatePanelItem('users');"
            class="w-[250px] max-lg:w-[200px] h-[200px] max-lg:h-[150px] text-white uppercase lg:text-xl transform transition-all duration-300 ease-in-out hover:translate-y-[-10px] hover:scale-[1.02] hover:rotate-[1deg] cardBox cursor-pointer">
            <div class="card">
                <img src="{{ asset('images/main-panel/btn-icons/users.svg') }}"
                    class="w-[105px] h-[105px] max-xl:w-[70px] max-xl:h-[70px]" alt="">
                <p class="text-center">Employee Mgmt</p>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function locatePanelItem(panelItem) {
        window.location.href = "{{ url('main-panel') }}/" + panelItem;
    }
</script>
@endsection
