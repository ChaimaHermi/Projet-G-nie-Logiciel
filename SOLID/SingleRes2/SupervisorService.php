namespace App\Services;

use App\Models\User;

class SupervisorService
{
    public function getSupervisors()
    {
        return User::with('roles')
            ->whereHas('roles', fn($q) => $q->where('name', 'supervisor'))
            ->get();
    }
}
