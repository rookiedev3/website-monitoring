<?php

namespace App\Http\Controllers;

class NotificationController extends Controller
{
    public function apiIndex()
    {
        $user = auth()->user();
        $notifications = $user->unreadNotifications()->take(10)->get()->map(function ($notif) {
            $data = $notif->data;
            $colorClass = $data['color'] ?? (($data['type'] ?? '') === 'website_down' ? 'danger' : 'success');
            $targetUrl = ! empty($data['incident_id'])
                ? route('incidents.show', $data['incident_id'])
                : ($data['action_url'] ?? route('incidents.index'));

            return [
                'id' => $notif->id,
                'is_unread' => is_null($notif->read_at),
                'title' => $data['website_name'] ?? 'Pemberitahuan System',
                'message' => $data['message'] ?? 'Status website telah diperbarui.',
                'color' => $colorClass,
                'time_ago' => $notif->created_at->diffForHumans(),
                'read_url' => route('notifications.readAndRedirect', [$notif->id, 'redirect' => $targetUrl]),
                'delete_url' => route('notifications.destroy', $notif->id),
            ];
        });

        return response()->json([
            'unread_count' => $user->unreadNotifications()->count(),
            'notifications' => $notifications,
        ]);
    }

    public function markAllRead()
    {
        auth()->user()->unreadNotifications->markAsRead();

        if (request()->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Semua notifikasi telah ditandai dibaca.',
            ]);
        }

        return back()->with('success', 'Semua notifikasi telah ditandai dibaca.');
    }

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

