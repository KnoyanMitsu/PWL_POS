<?php

namespace App\Http\Controllers;

use App\Models\BarangModel;
use App\Models\StokModel;
use App\Models\SupplierModel;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;

class StokController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            "title" => "Daftar Stok",
            "list" => ["Home", "Stok"],
        ];

        $page = (object) [
            "title" => "Daftar Stok yang terdaftar dalam sistem",
        ];

        $activeMenu = "stok";

        return view("stok.index", [
            "breadcrumb" => $breadcrumb,
            "page" => $page,
            "activeMenu" => $activeMenu,
        ]);
    }


    public function list(Request $request)
    {
        $datas = StokModel::select(
            "stok_id",
            "user_id",
            "barang_id",
            "supplier_id",
            "stok_tanggal",
            "stok_jumlah",
        )->with(["user","barang","supplier"]);


        return DataTables::of($datas)
            ->addIndexColumn()
            ->addColumn("aksi", function ($data) {
                // $btn = '<a href="' . url('/barang/' . $barang->barang_id) . '" class="btn btn-info btn-sm">Detail</a> ';
                // $btn .= '<a href="' . url('/barang/' . $barang->barang_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
                // $btn .= '<form class="d-inline-block" method="POST" action="' . url('/barang/' . $barang->barang_id) . '" style="display:inline;">'
                //     . csrf_field() . method_field('DELETE') .
                //     '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button>
                // </form>';

                $btn =
                    '<button onclick="modalAction(\'' .
                    url("/stok/" . $data->stok_id . "/confirm") .
                    '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(["aksi"])
            ->make(true);
    }

    public function detail(string $id) {
        $datas = StokModel::where(
            'penjualan_id', $id
        )->with(['barang','penjualan'])->get();
        return view('penjualan.detail', [
            "data" => $datas
        ]);
    }

    public function confirm(string $id) {
        $data= StokModel::with(['user','barang','supplier'])->find($id);

        return view("stok.confirm_ajax",[
            'data' => $data
        ]);
    }
    public function delete(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {

            $user = StokModel::find($id);
            if ($user) {
                 try{
                $user->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Data Berhasil dihapus'
                    ]);

                }catch(\Illuminate\Database\QueryException $e){
                    return response()->json([
                    'status' => false,
                    'message' => 'Terjadi Kesalahan'
                    ]);
                }
            }else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }
        return redirect('/');
    }
    public function create()
    {
        $barang = BarangModel::all();
        $supplier = SupplierModel::all();
        return view("stok.create",[
            'barang' => $barang,
            'supplier' => $supplier
        ]);
    }
         public function store(Request $reqeust)
    {
        if ($reqeust->ajax() || $reqeust->wantsJson()) {
            $rules = [
                "barang_id" => "required|integer",
                "supplier_id" => "required|integer",
            ];

            $validator = Validator::make($reqeust->all(), $rules);

            $reqeust->merge([
                'user_id' => auth()->id(),
                'stok_tanggal' => now(),
            ]);

            if ($validator->fails()) {
                return response()->json([
                    "status" => false,
                    "message" => "Validasi Gagal",
                    "msgField" => $validator->errors(),
                ]);
            }

            StokModel::create($reqeust->all());
            return response()->json([
                "status" => true,
                "message" => "Data user berhasil disimpan",
            ]);
        }
    }
}
