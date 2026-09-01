<?php

namespace App\Http\Controllers;

class NotificationController extends Controller
{
    public function destroy($id)
    {
        $notification = auth()->user()->notifications()->findOrFail($id);
        $notification->delete();

        if (request()->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Notifikasi berhasil dihapus.',
            ]);
        }

        return redirect()->back()->with('success', 'Notifikasi berhasil dihapus.');
    }
}
