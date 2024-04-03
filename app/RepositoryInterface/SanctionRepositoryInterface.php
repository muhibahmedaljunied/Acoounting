<?php
namespace App\RepositoryInterface;

use App\Repository\Sanction\SanctionRepository;
use App\Services\core\CoreStaffAttendanceService;
use App\Repository\HR\ExtraRepository as lRepository ;

interface SanctionRepositoryInterface{

    public function __construct(CoreStaffAttendanceService $attendance_core,lRepository $hr);
    public function create();
}
