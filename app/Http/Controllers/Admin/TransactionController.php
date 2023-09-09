<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Transaction_a; // モデルをインポート
use App\Models\Transaction_b;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Exception;

use function PHPUnit\Framework\throwException;

class TransactionController extends Controller
{
    //
    public function index()
    {
        return view('transaction.index');
    }

    public function success()
    {
        // トランザクションを開始
        DB::beginTransaction();

        try {
            // テーブル1への挿入
            $data1 = new Transaction_a();
            $data1->save();

            // テーブル2への挿入
            $data2 = new Transaction_b();
            $data2->save();

            // トランザクションをコミット
            DB::commit();

            return view('transaction.success')->with('success', 'データが正常に挿入されました');
        } catch (\Exception $e) {
            // エラーが発生した場合、トランザクションをロールバック
            DB::rollback();

            return view('transaction.exception')->with('error', 'データ挿入中にエラーが発生しました: ' . $e->getMessage());
        }
    }

    public function exception()
    {
        // トランザクション1を開始
        DB::beginTransaction();

        try {
            // テーブル1への挿入
            $data1 = new Transaction_a();
            $data1->save();

            // トランザクション2を開始
            DB::beginTransaction();

            try {
                // テーブル2への挿入
                $data2 = new Transaction_b();
                $data2->save();
                DB::commit();
            } catch (\Exception $e) {
                // エラーが発生した場合、トランザクションをロールバック
                DB::rollback();
                return view('transaction.exception')->with('error', 'データ挿入中にエラーが発生しました: ' . $e->getMessage());
            }

            //エラーを発生
            throw new Exception('トランザクション中にエラーが発生しました');

            // トランザクションをコミット
            DB::commit();

            return view('transaction.success')->with('erorr', 'データの挿入に失敗しました');
        } catch (\Exception $e) {
            // エラーが発生した場合、トランザクションをロールバック
            DB::rollback();

            return view('transaction.exception')->with('error', 'データ挿入中にエラーが発生しました: ' . $e->getMessage());
        }
    }
}
