<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    private function getCustomersData()
    {
        return [
            [
                'id' => 1,
                'name' => 'Ahmad Fauzi',
                'company' => 'PT Sinergi Abadi Kreatif',
                'phone' => '0812-9876-5432',
                'email' => 'ahmad.fauzi@sinergi.co.id',
                'address' => 'Jl. Asia Afrika No. 120, Bandung, Jawa Barat 40112',
                'total_orders' => 4,
                'total_spent' => 'Rp 28.500.000',
                'last_order_date' => '15 Agu 2026',
                'orders' => [
                    ['id' => 1, 'order_code' => 'TB-9021', 'product' => 'Custom Coach Jacket', 'qty' => 50, 'total' => 'Rp 9.250.000', 'status' => 'pending', 'date' => '15 Agu 2026'],
                    ['id' => 11, 'order_code' => 'TB-8942', 'product' => 'Custom Hoodie 330gsm', 'qty' => 40, 'total' => 'Rp 7.000.000', 'status' => 'completed', 'date' => '22 Jul 2026'],
                    ['id' => 12, 'order_code' => 'TB-8890', 'product' => 'Oversized Cotton T-Shirt', 'qty' => 100, 'total' => 'Rp 6.500.000', 'status' => 'completed', 'date' => '10 Jun 2026'],
                    ['id' => 13, 'order_code' => 'TB-8750', 'product' => 'Sublim Sport Jersey', 'qty' => 45, 'total' => 'Rp 5.750.000', 'status' => 'completed', 'date' => '18 Mei 2026'],
                ]
            ],
            [
                'id' => 2,
                'name' => 'Dimas Pratama',
                'company' => 'Komunitas Vespa Scooter Bandung',
                'phone' => '0813-2233-4455',
                'email' => 'dimas.vespa@gmail.com',
                'address' => 'Jl. Dago Elos No. 45, Coblong, Bandung 40135',
                'total_orders' => 2,
                'total_spent' => 'Rp 9.750.000',
                'last_order_date' => '14 Agu 2026',
                'orders' => [
                    ['id' => 2, 'order_code' => 'TB-9020', 'product' => 'Custom Hoodie 330gsm', 'qty' => 30, 'total' => 'Rp 5.250.000', 'status' => 'in_production', 'date' => '14 Agu 2026'],
                    ['id' => 21, 'order_code' => 'TB-8840', 'product' => 'Custom Coach Jacket', 'qty' => 25, 'total' => 'Rp 4.500.000', 'status' => 'completed', 'date' => '05 Jun 2026'],
                ]
            ],
            [
                'id' => 3,
                'name' => 'Siti Nurhaliza',
                'company' => 'Panitia Dies Natalis ITB',
                'phone' => '0819-8765-4321',
                'email' => 'siti.diesitb@gmail.com',
                'address' => 'Jl. Ganesha No. 10, Institut Teknologi Bandung, Bandung 40132',
                'total_orders' => 3,
                'total_spent' => 'Rp 19.500.000',
                'last_order_date' => '13 Agu 2026',
                'orders' => [
                    ['id' => 3, 'order_code' => 'TB-9019', 'product' => 'Oversized Cotton T-Shirt', 'qty' => 100, 'total' => 'Rp 6.500.000', 'status' => 'confirmed', 'date' => '13 Agu 2026'],
                    ['id' => 31, 'order_code' => 'TB-8902', 'product' => 'Sublim Sport Jersey', 'qty' => 50, 'total' => 'Rp 6.500.000', 'status' => 'completed', 'date' => '15 Jul 2026'],
                    ['id' => 32, 'order_code' => 'TB-8711', 'product' => 'Custom Hoodie 330gsm', 'qty' => 40, 'total' => 'Rp 6.500.000', 'status' => 'completed', 'date' => '02 Mei 2026'],
                ]
            ],
            [
                'id' => 4,
                'name' => 'Budi Santoso',
                'company' => 'BEM Fasilkom UI',
                'phone' => '0821-3344-5566',
                'email' => 'budi.santoso@bemfasilkom.org',
                'address' => 'Kampus UI Depok, Gedung Fasilkom, Depok, Jawa Barat 16424',
                'total_orders' => 5,
                'total_spent' => 'Rp 42.800.000',
                'last_order_date' => '10 Agu 2026',
                'orders' => [
                    ['id' => 4, 'order_code' => 'TB-9018', 'product' => 'Sublim Sport Jersey', 'qty' => 80, 'total' => 'Rp 10.800.000', 'status' => 'completed', 'date' => '10 Agu 2026'],
                ]
            ],
            [
                'id' => 5,
                'name' => 'Rian Hidayat',
                'company' => 'Klinik Medika Pratama',
                'phone' => '0857-1122-3344',
                'email' => 'rian.h@medika.com',
                'address' => 'Jl. Buah Batu No. 201, Bandung 40265',
                'total_orders' => 2,
                'total_spent' => 'Rp 11.600.000',
                'last_order_date' => '08 Agu 2026',
                'orders' => [
                    ['id' => 5, 'order_code' => 'TB-9017', 'product' => 'Kemeja PDL Tactical', 'qty' => 40, 'total' => 'Rp 5.800.000', 'status' => 'completed', 'date' => '08 Agu 2026'],
                ]
            ],
        ];
    }

    public function index()
    {
        $customers = $this->getCustomersData();
        return view('admin.customers.index', compact('customers'));
    }

    public function show($id)
    {
        $customers = $this->getCustomersData();
        $customer = collect($customers)->firstWhere('id', (int)$id) ?? $customers[0];

        return view('admin.customers.show', compact('customer'));
    }
}
