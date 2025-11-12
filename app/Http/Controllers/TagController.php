<?php

namespace Modules\Helpcenter\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Modules\Helpcenter\Models\Tag;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('helpcenter::index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('helpcenter::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {}

    /**
     * Show a tag page with its taggables (filterable by taggable_type).
     *
     * Query params:
     * - type: morph alias or FQCN (eg. "person", "article")
     * - q: search on common columns (name/title)
     * - sort: recent|name
     * - per_page: int
     */
    public function show(Request $request, Tag $tag)
    {
        $perPage = min((int) $request->query('per_page', 24), 100);
        $q       = trim((string) $request->query('q', ''));
        $sort    = $request->query('sort', 'recent'); // recent|name
        $type    = $request->query('type');           // morph alias (eg. "person")

        // 1) Lister les types réellement présents pour ce tag (d'après la pivot)
        $rawTypeRows = DB::table('taggables')
            ->select('taggable_type', DB::raw('COUNT(*) as total'))
            ->where('tag_id', $tag->id)
            ->groupBy('taggable_type')
            ->orderBy('total', 'desc')
            ->get();

        // On résout alias -> FQCN via le morphMap (sinon garde tel quel si déjà FQCN)
        $availableTypes = $rawTypeRows->map(function ($row) {
            $alias = $row->taggable_type;
            $fqcn  = Relation::getMorphedModel($alias) ?? $alias;
            return [
                'alias' => $alias,
                'fqcn'  => $fqcn,
                'total' => (int) $row->total,
                'label' => Str::title(str_replace(['-', '_', '\\'], [' ', ' ', ' '], class_basename($fqcn))),
            ];
        })->values();

        // 2) Si un type est demandé, on ne liste que ce type (pagination)
        $items = null;
        $activeType = null;

        if ($type) {
            $activeType = $type;
            $fqcn = Relation::getMorphedModel($type) ?? $type;

            // Relation dynamique morphedByMany vers CE type
            /** @var \Illuminate\Database\Eloquent\Model $model */
            $model = new $fqcn();
            $table = $model->getTable();

            $query = $tag->morphedByMany($fqcn, 'taggable')
                ->with(['tags:id,name,slug,color'])
                ->select("{$table}.*");

            // Recherche basique : name/title si colonnes existantes
            if ($q !== '') {
                $query->where(function ($w) use ($table, $q) {
                    if (Schema::hasColumn($table, 'name')) {
                        $w->orWhere("{$table}.name", 'like', "%{$q}%");
                    }
                    if (Schema::hasColumn($table, 'title')) {
                        $w->orWhere("{$table}.title", 'like', "%{$q}%");
                    }
                });
            }

            // Tri
            if ($sort === 'name' && Schema::hasColumn($table, 'name')) {
                $query->orderBy("{$table}.name");
            } elseif ($sort === 'name' && Schema::hasColumn($table, 'title')) {
                $query->orderBy("{$table}.title");
            } else {
                $query->latest("{$table}.created_at");
            }

            $items = $query->paginate($perPage)->appends($request->query());
        }

        // 3) Si aucun type demandé, on propose un aperçu par type (jusqu’à 6 items par type)
        $samplesByType = [];
        if (!$items) {
            foreach ($availableTypes as $t) {
                $fqcn  = $t['fqcn'];
                $model = new $fqcn();
                $table = $model->getTable();

                $q2 = $tag->morphedByMany($fqcn, 'taggable')
                    ->with(['tags:id,name,slug,color'])
                    ->select("{$table}.*")
                    ->latest("{$table}.created_at");

                $samplesByType[$t['alias']] = [
                    'meta'   => $t,
                    'items'  => $q2->limit(6)->get(),
                ];
            }
        }

        return view('helpcenter::tags.show', [
            'tag'            => $tag,
            'availableTypes' => $availableTypes, // pour le select/onglets
            'activeType'     => $activeType,     // alias ou null
            'items'          => $items,          // paginator si type choisi
            'samplesByType'  => $samplesByType,  // sinon, aperçu groupé
            'filters'        => [
                'q'        => $q,
                'sort'     => $sort,
                'per_page' => $perPage,
            ],
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('helpcenter::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {}
}
