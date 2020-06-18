<?php

namespace App\Http\Controllers;

use App\Task;
use App\Jobs\ProcessCommands;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Log;

/**
 * @OA\Info(title="API Queues", version="1.0")
 *
 * @OA\Server(url="http://localhost/monkey-test-back/public/index.php")
 */
class TaskController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/task",
     *     summary="Lista todos los trabajos",
     *     @OA\Response(
     *         response=200,
     *         description="Muestra todos los trabajos."
     *     ),
     * security={{
     *     "Authorization":{}
     *   }}
     * )
     */
    public function index()
    {
        return response()->json(['data' => Task::all()]);
    }


    /**
     * @OA\Post(
     *     path="/api/task/{priority?}",
     *     summary="Guarda un nuevo trabajo",
     * @OA\RequestBody(
     *     description="Nuevo trabajo a guardar",
     *     required=true,
     *     @OA\JsonContent(example={"command": "sleep 2 && mkdir ./oooooo"}),
     * ),
     * @OA\Parameter(
     *     name="priority?",
     *     required=false,
     *     in="path",
     *     description="Prioridad del trabajo HIGH || LOW",
     *     @OA\Schema(
     *         type="string",
     *         example="low" 
     *     )
     *   ),
     * 
     *     @OA\Response(
     *         response=200,
     *         description="Muestra todos los trabajos.",
     *         @OA\JsonContent(
     *          type="object",
     *          @OA\Property(property="Task", type="object")
     *     ),
     * ),
     *     @OA\Response(response=403, description="No Authenticado"),
     * security={{
     *     "Authorization":{}
     *   }}
     * )"
     */
    public function store(Request $request, $priority = "low")
    {
        Log::info("Auth::user()".Auth::user()["id"]);
        
        $task = new Task;
        $task->command = $request->command;
        $task->priority = strtolower($priority) == "high" ? "high" : "low";
        $task->submitter_id = Auth::user()["id"];
        //Guardamos el cambio en nuestro modelo
        $task->save();

        ProcessCommands::dispatch($task)->onQueue(strtolower($priority) == "high" ? "high" : "low");

        return response()->json(['data' => $task], 202);
    }

        /**
     * @OA\Get(
     *     path="/api/task/{id}",
     *     summary="Obtiene el trabajo segun id",
     * @OA\Parameter(
     *     name="id",
     *     required=true,
     *     in="path",
     *     description="Id del  trabajo a obtener",
     *     @OA\Schema(
     *         type="string",
     *         example="1" 
     *     )
     *   ),
     * 
     *     @OA\Response(
     *         response=200,
     *         description="Muestra un trabajo segun id.",
     *         @OA\JsonContent(
     *          type="object",
     *          @OA\Property(property="Task", type="object")
     *     ),
     * ),
     *     @OA\Response(response=403, description="No Authenticado"),
     * security={{
     *     "Authorization":{}
     *   }}
     * )"
     */
    public function show($id)
    {
        $task = Task::find($id);

        if($task == null)
            return response()->json(["data" => "sin registros por id ".$id]);

        return response()->json(['data' => $task], 200);
    }

            /**
     * @OA\Put(
     *     path="/api/task/{id}",
     *     summary="Actualiza el comando del trabajo segun id",
     * @OA\RequestBody(
     *     description="Nuevo comando a actualizar",
     *     required=true,
     *     @OA\JsonContent(example={"command": "sleep 2 && mkdir ./oooooo"}),
     * ),
     *      * @OA\Parameter(
     *     name="id",
     *     required=true,
     *     in="path",
     *     description="Id del trabajo",
     *     @OA\Schema(
     *         type="string",
     *         example="1" 
     *     )
     *   ),
     *     @OA\Response(
     *         response=200,
     *         description="Muestra un trabajo segun id.",
     *         @OA\JsonContent(
     *          type="object",
     *          @OA\Property(property="Task", type="object")
     *     ),
     * ),
     *     @OA\Response(response=403, description="No Authenticado"),
     * security={{
     *     "Authorization":{}
     *   }}
     * )"
     */
    public function update(Request $request, $id)
    {
        $task = Task::find($id);

        if($task == null)
            return response()->json(["data" => "sin registros por id ".$id]);

        $task->command = $request->command;
        $task->save();

        return response()->json(['data' => $task]);
    }

    /**
     * @OA\Delete(
     *     path="/api/task/{id}",
     *     summary="Borra un trabajo segun id",
     * @OA\Parameter(
     *     name="id",
     *     required=true,
     *     in="path",
     *     description="Id del  trabajo a borrar",
     *     @OA\Schema(
     *         type="string",
     *         example="1" 
     *     )
     *   ),
     *     @OA\Response(
     *         response=200,
     *         description="Id del trabajo eliminado.",
     *         @OA\JsonContent(
     *          type="object",
     *          @OA\Property(property="Task", type="object")
     *     ),
     * ),
     *     @OA\Response(response=403, description="No Authenticado"),
     * security={{
     *     "Authorization":{}
     *   }}
     * )"
     */
    public function destroy($id)
    {
        $task = Task::find($id);
        if($task == null)
            return response()->json(["data" => "sin registros por id ".$id]);
        
        return response()->json(["data" => $task->delete()]);
        
    }

    /**
     * @OA\Get(
     *     path="/api/task/average",
     *     summary="Obtiene un promedio de finalizacion de trabajos",
     *     @OA\Response(
     *         response=200,
     *         description="Tiempo de promedio de respuesta."
     *     ),
     * )
     */
    public function average()
    {
        $tasks = Task::whereNotNull('execution_time')->get();
        
        $avegare = 0;
        
        if(count($tasks) > 0){
            
            foreach($tasks as $task){
                $avegare += $task->execution_time;
            }
            
            $avegare = $avegare / count($tasks);
        }
        
        return response()->json(["average" => number_format($avegare, 5), "Cantidad de trabajos" => count($tasks)]);
    }
}