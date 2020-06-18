<?php

namespace App\Jobs;

use App\Task as TaskModel;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Cache;

class ProcessCommands implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $task;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(TaskModel $task)
    {
        $this->task = $task;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $start = microtime(true);
            
            Log::info('Iniciando task id: ' .$this->task->id);
            Log::info("Comando a ejecutar: ".$this->task->command);
            $this->setStatus("procesando", null);
            echo exec($this->task->command);
            $executionTime = microtime(true) - $start;
            $this->setStatus("procesado", $executionTime);

            Log::info('Finalizando task id: ' .$this->task->id);

        } catch (\Exception $e) {
            Log::error('Exception task id: ' .$this->task->id. " Error: ".$e->getMessage());
        }
    }

    private function setStatus($status, $executionTime = null){
        $this->task->processor_id = $status;
        if($executionTime != null)
            $this->task->execution_time = $executionTime;
        $this->task->save();
    }
}
