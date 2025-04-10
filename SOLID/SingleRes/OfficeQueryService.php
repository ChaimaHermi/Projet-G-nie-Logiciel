// app/Services/OfficeQueryService.php
namespace App\Services;

use App\Models\Office;

class OfficeQueryService
{
    public function getByCluster(array $clusterIds): array
    {
        return Office::whereIn('cluster_id', $clusterIds)
                   ->pluck('id')
                   ->toArray();
    }
}