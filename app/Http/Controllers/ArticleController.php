<?php

namespace App\Http\Controllers;

use App\Helpers\JsonResponse;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index(Request $request)
  {
    $limit = $request->query('limit', 10);
    $page = $request->query('page', 1);
    $query = Article::query();
    $total = $query->count();
    $data = $query->paginate($limit);

    return JsonResponse::success(
      data: ArticleResource::collection($data),
      meta: JsonResponse::meta(
        total: $total,
        page: $page,
        limit: $limit
      )
    );
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    try {
      $title = $request->post('title');

      $data = Article::create([
        'slug' => Str::slug($title),
        'title' => $title,
        'image' => $request->post('image'),
        'description' => $request->post('description'),
        'body' => $request->post('body'),
      ]);

      return JsonResponse::success(
        code: Response::HTTP_CREATED,
        message: 'ok',
        data: new ArticleResource($data)
      );
    } catch (Exception $exception) {
      return JsonResponse::error(
        code: Response::HTTP_INTERNAL_SERVER_ERROR,
        message: $exception->getMessage()
      );
    }
  }

  /**
   * Display the specified resource.
   */
  public function show(string $id)
  {
    $data = Article::where('slug', $id)->first();

    if (!$data) {
      return JsonResponse::error(
        code: Response::HTTP_NOT_FOUND,
        message: 'not found'
      );
    }

    return JsonResponse::success(
      code: Response::HTTP_OK,
      message: 'ok',
      data: new ArticleResource($data)
    );
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, string $id)
  {
    try {
      $article = Article::find($id);
      $titleId = $request->post('title_id');
      $titleEn = $request->post('title_en');

      $article->update([
        'slug_id' => Str::slug($titleId),
        'slug_en' => Str::slug($titleEn),
        'title_id' => $titleId,
        'title_en' => $titleEn,
        'image' => $request->post('image'),
        'description_id' => $request->post('description_id'),
        'description_en' => $request->post('description_en'),
        'body_id' => $request->post('body_id'),
        'body_en' => $request->post('body_en'),
      ]);

      return JsonResponse::success(
        code: Response::HTTP_OK,
        message: 'ok',
        data: new ArticleResource($article)
      );
    } catch (Exception $exception) {
      return JsonResponse::error(
        code: Response::HTTP_INTERNAL_SERVER_ERROR,
        message: $exception->getMessage()
      );
    }
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    try {
      $article = Article::find($id);

      $article->delete();

      return JsonResponse::success(
        code: Response::HTTP_OK,
        message: 'ok',
        data: null
      );
    } catch (Exception $exception) {
      return JsonResponse::error(
        code: Response::HTTP_INTERNAL_SERVER_ERROR,
        message: $exception->getMessage()
      );
    }
  }
}
