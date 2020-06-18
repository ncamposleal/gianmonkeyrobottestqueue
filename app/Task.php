<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *   type="object",
 *   required={"command"},
 * )
 */
class Task extends Model
{
    /**
     * @OA\Property(type="integer", format="int64")
     */
    public $id;

    /**
     * @OA\Property(type="timestamp", format="date-time")
     */
    private $created_at;	
    
    
    /**
     * @OA\Property(type="timestamp", format="date-time")
     */
    private $updated_at;
    
    /**
     * @OA\Property(type="string")
     */
    private $submitter_id;
 
    /**
     * @OA\Property(type="string")
     */    
    private $processor_id;
    
    /**
     * @OA\Property(type="string")
     */
    private $command;

    /**
     * @OA\Property(type="decimal")
     */
    private $execution_time;
    
    /**
     * @OA\Property(type="string")
     */    
    private $priority;
}
