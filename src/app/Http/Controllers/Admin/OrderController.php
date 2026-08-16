<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = [
            [
                'id' => 1,
                'order_code' => 'TB-9021',
                'customer_name' => 'Ahmad Fauzi',
                'company_or_institution' => 'PT Sinergi Abadi Kreatif',
                'phone' => '0812-9876-5432',
                'email' => 'ahmad.fauzi@sinergi.co.id',
                'product_name' => 'Custom Coach Jacket',
                'material' => 'Taslan Milky Waterproof',
                'size_breakdown' => 'M: 15 pcs, L: 25 pcs, XL: 10 pcs',
                'quantity' => 50,
                'total_price' => 'Rp 9.250.000',
                'status' => 'pending',
                'created_at' => '15 Agu 2026, 14:30 WIB',
            ],
            [
                'id' => 2,
                'order_code' => 'TB-9020',
                'customer_name' => 'Dimas Pratama',
                'company_or_institution' => 'Komunitas Vespa Scooter Bandung',
                'phone' => '0813-2233-4455',
                'email' => 'dimas.vespa@gmail.com',
                'product_name' => 'Custom Hoodie 330gsm',
                'material' => 'Heavyweight Cotton Fleece 330gsm',
                'size_breakdown' => 'L: 20 pcs, XL: 10 pcs',
                'quantity' => 30,
                'total_price' => 'Rp 5.250.000',
                'status' => 'in_production',
                'created_at' => '14 Agu 2026, 10:15 WIB',
            ],
            [
                'id' => 3,
                'order_code' => 'TB-9019',
                'customer_name' => 'Siti Nurhaliza',
                'company_or_institution' => 'Panitia Dies Natalis ITB',
                'phone' => '0819-8765-4321',
                'email' => 'siti.diesitb@gmail.com',
                'product_name' => 'Oversized Cotton T-Shirt',
                'material' => 'Cotton Combed 24s Premium',
                'size_breakdown' => 'S: 20, M: 40, L: 30, XL: 10 pcs',
                'quantity' => 100,
                'total_price' => 'Rp 6.500.000',
                'status' => 'confirmed',
                'created_at' => '13 Agu 2026, 09:00 WIB',
            ],
            [
                'id' => 4,
                'order_code' => 'TB-9018',
                'customer_name' => 'Budi Santoso',
                'company_or_institution' => 'BEM Fasilkom UI',
                'phone' => '0821-3344-5566',
                'email' => 'budi.santoso@bemfasilkom.org',
                'product_name' => 'Sublim Sport Jersey',
                'material' => 'Drifit Milano Quick-Dry',
                'size_breakdown' => 'S: 10, M: 30, L: 30, XXL: 10 pcs',
                'quantity' => 80,
                'total_price' => 'Rp 10.800.000',
                'status' => 'completed',
                'created_at' => '10 Agu 2026, 16:45 WIB',
            ],
            [
                'id' => 5,
                'order_code' => 'TB-9017',
                'customer_name' => 'Rian Hidayat',
                'company_or_institution' => 'Klinik Medika Pratama',
                'phone' => '0857-1122-3344',
                'email' => 'rian.h@medika.com',
                'product_name' => 'Kemeja PDL Tactical',
                'material' => 'Japan Drill High Grade',
                'size_breakdown' => 'M: 15, L: 20, XL: 5 pcs',
                'quantity' => 40,
                'total_price' => 'Rp 5.800.000',
                'status' => 'completed',
                'created_at' => '08 Agu 2026, 11:20 WIB',
            ],
        ];

        return view('admin.orders.index', compact('orders'));
    }

    public function create()
    {
        $products = [
            ['id' => 1, 'name' => 'Custom Hoodie 330gsm', 'base_price' => 175000],
            ['id' => 2, 'name' => 'Sublim Sport Jersey', 'base_price' => 135000],
            ['id' => 3, 'name' => 'Oversized Cotton T-Shirt', 'base_price' => 65000],
            ['id' => 4, 'name' => 'Custom Coach Jacket', 'base_price' => 185000],
            ['id' => 5, 'name' => 'Kemeja PDL Tactical', 'base_price' => 145000],
        ];

        $materials = [
            'Heavyweight Cotton Fleece 330gsm',
            'Cotton Combed 24s Premium',
            'Taslan Milky Waterproof',
            'Drifit Milano Quick-Dry',
            'Japan Drill High Grade',
            'Linen Stretch Weave',
        ];

        return view('admin.orders.create', compact('products', 'materials'));
    }

    public function store(Request $request)
    {
        return redirect()->route('admin.pesanan.index')->with('success', 'Pesanan kustom garmen baru berhasil dibuat!');
    }

    public function show($id)
    {
        $order = [
            'id' => $id,
            'order_code' => 'TB-9021',
            'customer_name' => 'Ahmad Fauzi',
            'company_or_institution' => 'PT Sinergi Abadi Kreatif',
            'phone' => '0812-9876-5432',
            'email' => 'ahmad.fauzi@sinergi.co.id',
            'shipping_address' => 'Jl. Asia Afrika No. 120, Gedung Wisma Sinergi Lt. 4, Bandung, Jawa Barat 40112',
            'product_name' => 'Custom Coach Jacket',
            'category' => 'Jaket & Outerwear',
            'color' => 'Navy Blue with Silver snap buttons',
            'material' => 'Taslan Milky Waterproof + Furing Asahi',
            'quantity' => 50,
            'unit_price' => 185000,
            'subtotal' => 9250000,
            'tax' => 0,
            'total_price' => 9250000,
            'status' => 'pending',
            'created_at' => '15 Agu 2026, 14:30 WIB',
            'size_breakdown' => [
                ['size' => 'M', 'qty' => 15],
                ['size' => 'L', 'qty' => 25],
                ['size' => 'XL', 'qty' => 10],
            ],
            'custom_notes' => "Mohon bordir logo perusahaan di dada kiri (diameter 7cm) dan sablon tulisan 'SINERGI BOLD 2026' di punggung belakang. Deadline pengiriman tanggal 30 Agustus 2026 untuk keperluan annual gathering.",
            'design_file' => 'https://images.unsplash.com/photo-1598033129183-c4f50c736f10?w=600&auto=format&fit=crop&q=80',
            'design_file_name' => 'Mockup_Desain_Sinergi_2026.pdf',
        ];

        return view('admin.orders.show', compact('order'));
    }

    public function update(Request $request, $id)
    {
        return redirect()->route('admin.pesanan.show', $id)->with('success', 'Informasi dan status pesanan berhasil diperbarui!');
    }

    public function invoice($id)
    {
        $order = [
            'id' => $id,
            'order_code' => 'TB-9021',
            'invoice_number' => 'INV/TB/2026/08/9021',
            'invoice_date' => '15 Agustus 2026',
            'due_date' => '22 Agustus 2026',
            'customer_name' => 'Ahmad Fauzi',
            'company_or_institution' => 'PT Sinergi Abadi Kreatif',
            'phone' => '0812-9876-5432',
            'email' => 'ahmad.fauzi@sinergi.co.id',
            'shipping_address' => 'Jl. Asia Afrika No. 120, Gedung Wisma Sinergi Lt. 4, Bandung, Jawa Barat 40112',
            'product_name' => 'Custom Coach Jacket',
            'color' => 'Navy Blue',
            'quantity' => 50,
            'unit_price' => 185000,
            'subtotal' => 9250000,
            'tax' => 0,
            'shipping_cost' => 0,
            'total_price' => 9250000,
            'status' => 'pending',
            'bank_info' => [
                'bank_name' => 'Bank Central Asia (BCA)',
                'account_number' => '8420-9988-771',
                'account_name' => 'PT Tigabenang Busana Indonesia',
            ]
        ];

        return view('admin.orders.invoice', compact('order'));
    }

    public function destroy($id)
    {
        return redirect()->route('admin.pesanan.index')->with('success', 'Pesanan berhasil dihapus.');
    }
}
