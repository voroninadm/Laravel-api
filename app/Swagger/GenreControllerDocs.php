<?php

namespace App\Swagger;

/**
 * @OA\Get(
 *     path="/api/genres",
 *     security={{"Pass by token":{}}},
 *     summary="Получить все жанры",
 *     description="Получить список всех существующих жанров.",
 *     operationId="getGenres",
 *     tags={"Genres"},
 *
 *     @OA\Response(
 *         response=200,
 *         description="Успешное получение списка жанров",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="response", type="string", example="true"),
 *             @OA\Property(
 *                 property="data",
 *                 type="array",
 *                 @OA\Items(
 *                     type="object",
 *                     @OA\Property(property="id", type="integer", example=1),
 *                     @OA\Property(property="name", type="string", example="Action"),
 *                 )
 *             ),
 *             example={
 *                 "response": "true",
 *                 "data": {
 *                     {
 *                         "id": 1,
 *                         "name": "Action",
 *                     },
 *                     {
 *                         "id": 2,
 *                         "name": "Animation",
 *                     }
 *                 }
 *             }
 *         )
 *     ),
 * )
 *
 * @OA\Patch(
 *     path="/api/genres/{id}",
 *     security={{"Pass by token":{}}},
 *     summary="Изменить жанр",
 *     description="Изменить существующий жанр по его Id.",
 *     operationId="updateGenre",
 *     tags={"Genres"},
 *
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID жанра",
 *         @OA\Schema(type="integer", example=11)
 *     ),
 *
 *     @OA\RequestBody(
 *         required=true,
 *         description="Информация для обновления жанра",
 *         @OA\JsonContent(
 *             required={"name"},
 *             @OA\Property(property="name", type="string", example="Horror"),
 *         )
 *     ),
 *
 *     @OA\Response(
 *         response=200,
 *         description="Жанр успешно обновлен.",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="response", type="string", example="true"),
 *             @OA\Property(
 *                  property="data",
 *                  type="array",
 *                  @OA\Items(
 *                      type="object",
 *                      @OA\Property(property="id", type="integer", example=11),
 *                      @OA\Property(property="name", type="string", example="Horror"),
 *                  )
 *              ),
 *         )
 *     ),
 *
 *     @OA\Response(
 *         response=404,
 *         description="Жанр не обнаружен",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="response", type="string", example="false"),
 *             @OA\Property(property="message", type="string", example="Запрашиваемая страница не существует."),         )
 *     ),
 *
 *     @OA\Response(
 *         response=422,
 *         description="Ошибка валидации",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="response", type="string", example="false"),
 *             @OA\Property(property="message", type="string", example="Переданные данные не корректны."),
 *             @OA\Property(
 *                 property="errors",
 *                 type="object",
 *                 @OA\Property(property="name", type="array", @OA\Items(type="string", example="Поле name обязательно.")),
 *             )
 *         )
 *     ),
 * )
 *
 */
class GenreControllerDocs
{
}
