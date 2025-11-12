<?php

namespace Modules\Helpcenter\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Helpcenter\Models\Tag;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        // --- People tags (used with Person::class) ---
        $personTags = [
            ['name' => 'Land Surveyor',     'slug' => 'land-surveyor',     'color' => '#10B981', 'description' => 'Topography, GNSS/RTK and GIS.'],
            ['name' => 'Agronomist',        'slug' => 'agronomist',        'color' => '#059669', 'description' => 'Crop systems, soils and inputs.'],
            ['name' => 'GIS Technician',    'slug' => 'gis-technician',    'color' => '#047857', 'description' => 'Geospatial data, QGIS, PostGIS.'],
            ['name' => 'Architect',         'slug' => 'architect',         'color' => '#2563EB', 'description' => 'Plans, permits and site layout.'],
            ['name' => 'Web Developer',     'slug' => 'web-developer',     'color' => '#EF4444', 'description' => 'Laravel, Livewire, APIs.'],
            ['name' => 'Legal Advisor',     'slug' => 'legal-advisor',     'color' => '#1F2937', 'description' => 'Permits, land use and contracts.'],
            ['name' => 'Farmer',            'slug' => 'farmer',            'color' => '#84CC16', 'description' => 'Field operations and husbandry.'],
            ['name' => 'Volunteer',         'slug' => 'volunteer',         'color' => '#A3A3A3', 'description' => 'On-site support and tasks.'],
            ['name' => 'WWOOFer',           'slug' => 'wwoofer',           'color' => '#9CA3AF', 'description' => 'Organic farm work exchange.'],
            ['name' => 'Electrician',       'slug' => 'electrician',       'color' => '#F59E0B', 'description' => 'AC/DC wiring and safety.'],
            ['name' => 'Carpenter',         'slug' => 'carpenter',         'color' => '#D97706', 'description' => 'Woodworks, structures and joinery.'],
            ['name' => 'Mechanic',          'slug' => 'mechanic',          'color' => '#6B7280', 'description' => 'Engines, pumps and repairs.'],
            ['name' => 'Drone Pilot',       'slug' => 'drone-pilot',       'color' => '#3B82F6', 'description' => 'Aerial mapping and inspection.'],
            ['name' => 'Skipper',           'slug' => 'skipper',           'color' => '#06B6D4', 'description' => 'Boating operations and safety.'],
        ];

        // --- Helpcenter/global tags (QAPAS topics) ---
        $helpTags = [
            // Core helpcenter
            ['name' => 'How-to',            'slug' => 'how-to',            'color' => '#2563EB', 'description' => 'Step-by-step guides.'],
            ['name' => 'Troubleshooting',   'slug' => 'troubleshooting',   'color' => '#1D4ED8', 'description' => 'Fix common issues.'],
            ['name' => 'FAQ',               'slug' => 'faq',               'color' => '#1E3A8A', 'description' => 'Frequently asked questions.'],

            // Mobile / apps
            ['name' => 'iOS',               'slug' => 'ios',               'color' => '#111827', 'description' => 'iPhone/iPad apps and Shortcuts.'],
            ['name' => 'Android',           'slug' => 'android',           'color' => '#374151', 'description' => 'Android apps and settings.'],
            ['name' => 'SW Maps',           'slug' => 'sw-maps',           'color' => null,      'description' => 'Field data collection app.'],

            // Backend / devstack
            ['name' => 'Laravel',           'slug' => 'laravel',           'color' => '#EF4444', 'description' => 'Backend, Fortify and APIs.'],
            ['name' => 'Livewire',          'slug' => 'livewire',          'color' => '#F87171', 'description' => 'Reactive components.'],
            ['name' => 'Filament',          'slug' => 'filament',          'color' => '#DC2626', 'description' => 'Admin panels and forms.'],
            ['name' => 'Hexagonal Architecture', 'slug' => 'hexagonal-architecture', 'color' => null, 'description' => 'Ports & adapters, testing.'],
            ['name' => 'DDD',               'slug' => 'ddd',               'color' => null,      'description' => 'Domain-driven design.'],
            ['name' => 'Spatie Media Library', 'slug' => 'spatie-media-library', 'color' => null, 'description' => 'Media and conversions.'],

            // Mapping / GIS
            ['name' => 'Leaflet',           'slug' => 'leaflet',           'color' => '#334155', 'description' => 'Web mapping and layers.'],
            ['name' => 'OpenStreetMap',     'slug' => 'openstreetmap',     'color' => null,      'description' => 'Base maps and data.'],
            ['name' => 'WMS',               'slug' => 'wms',               'color' => null,      'description' => 'OGC web map services.'],
            ['name' => 'GeoJSON',           'slug' => 'geojson',           'color' => null,      'description' => 'Vector data interchange.'],
            ['name' => 'QGIS',              'slug' => 'qgis',              'color' => null,      'description' => 'Desktop GIS workflows.'],
            ['name' => 'PostGIS',           'slug' => 'postgis',           'color' => null,      'description' => 'Spatial SQL and storage.'],
            ['name' => 'GDAL',              'slug' => 'gdal',              'color' => null,      'description' => 'Raster/vector tools.'],
            ['name' => 'CRS EPSG:4326',     'slug' => 'epsg-4326',         'color' => null,      'description' => 'WGS84 lat/lng.'],
            ['name' => 'CRS EPSG:3763',     'slug' => 'epsg-3763',         'color' => null,      'description' => 'ETRS89 / PT-TM06.'],
            ['name' => 'DEM & Contours',    'slug' => 'dem-contours',      'color' => null,      'description' => 'Elevation models and lines.'],
            ['name' => 'LIDAR',             'slug' => 'lidar',             'color' => null,      'description' => 'Point clouds and DSM/DTM.'],

            // GNSS / RTK toolchain
            ['name' => 'GNSS',              'slug' => 'gnss',              'color' => '#6B7280', 'description' => 'RTK, NTRIP, base/rover.'],
            ['name' => 'RTK',               'slug' => 'rtk',               'color' => null,      'description' => 'Real-time kinematic positioning.'],
            ['name' => 'NTRIP',             'slug' => 'ntrip',             'color' => null,      'description' => 'Caster, mountpoints and RTCM.'],
            ['name' => 'ArduSimple',        'slug' => 'ardusimple',        'color' => null,      'description' => 'Boards, bridges and antennas.'],
            ['name' => 'u-blox F9P',        'slug' => 'ublox-f9p',         'color' => null,      'description' => 'ZED-F9P setup and tuning.'],
            ['name' => 'Emlid',             'slug' => 'emlid',             'color' => null,      'description' => 'Reach RS/RS+/RS2 devices.'],

            // Land use / Portugal regs (QAPAS)
            ['name' => 'REN',               'slug' => 'ren',               'color' => null,      'description' => 'National Ecological Reserve (PT).'],
            ['name' => 'RJREN',             'slug' => 'rjren',             'color' => null,      'description' => 'Portuguese REN legal framework.'],
            ['name' => 'RJUE',              'slug' => 'rjue',              'color' => null,      'description' => 'Urbanization & Building Regime (PT).'],
            ['name' => 'CCDR Centro',       'slug' => 'ccdr-centro',       'color' => null,      'description' => 'Regional coordination authority.'],
            ['name' => 'APA',               'slug' => 'apa',               'color' => null,      'description' => 'Portuguese Environment Agency.'],

            // Agro / farm systems
            ['name' => 'Permaculture',      'slug' => 'permaculture',      'color' => null,      'description' => 'Design patterns and ethics.'],
            ['name' => 'Agroforestry',      'slug' => 'agroforestry',      'color' => null,      'description' => 'Trees, crops and integration.'],
            ['name' => 'Terraces (Socalcos/Leiras)', 'slug' => 'terraces', 'color' => null,      'description' => 'Design and modelling of terraces.'],
            ['name' => 'Water Retention',   'slug' => 'water-retention',   'color' => null,      'description' => 'Ponds, swales and small dams.'],
            ['name' => 'Irrigation',        'slug' => 'irrigation',        'color' => null,      'description' => 'Design, scheduling and hardware.'],
            ['name' => 'Silvopasture',      'slug' => 'silvopasture',      'color' => null,      'description' => 'Trees + grazing systems.'],
            ['name' => 'Sheep',             'slug' => 'sheep',             'color' => null,      'description' => 'Breeds, health and fencing.'],
            ['name' => 'Hedgerows',         'slug' => 'hedgerows',         'color' => null,      'description' => 'Living fences and biodiversity.'],
            ['name' => 'Orchard',           'slug' => 'orchard',           'color' => null,      'description' => 'Fruit trees and guilds.'],
            ['name' => 'Vineyard',          'slug' => 'vineyard',          'color' => null,      'description' => 'Trellising, pruning and care.'],
        ];

        // --- Low-tech / appropriate technology (replaces previous energy/workshop/boats) ---
        $lowtechTags = [
            ['name' => 'Low-tech',                 'slug' => 'low-tech',                 'color' => null, 'description' => 'Simple, repairable, human-scale solutions.'],
            ['name' => 'Appropriate Technology',   'slug' => 'appropriate-technology',   'color' => null, 'description' => 'Context-fit tools for rural settings.'],
            ['name' => 'Off-grid',                 'slug' => 'off-grid',                 'color' => null, 'description' => 'Living and operating without the grid.'],

            // Cooking / heating
            ['name' => 'Solar Cooker',             'slug' => 'solar-cooker',             'color' => null, 'description' => 'Cooking with sunlight.'],
            ['name' => 'Solar Dehydrator',         'slug' => 'solar-dehydrator',         'color' => null, 'description' => 'Sun-powered food drying.'],
            ['name' => 'Rocket Stove',             'slug' => 'rocket-stove',             'color' => null, 'description' => 'Efficient biomass cookstove.'],
            ['name' => 'Rocket Mass Heater',       'slug' => 'rocket-mass-heater',       'color' => null, 'description' => 'Low-fuel space heating with thermal mass.'],
            ['name' => 'Cob Oven',                 'slug' => 'cob-oven',                 'color' => null, 'description' => 'Earthen bread/pizza ovens.'],

            // Water / sanitation
            ['name' => 'Rainwater Harvesting',     'slug' => 'rainwater-harvesting',     'color' => null, 'description' => 'Catchment, gutters and tanks.'],
            ['name' => 'Slow Sand Filter',         'slug' => 'slow-sand-filter',         'color' => null, 'description' => 'Low-tech water purification.'],
            ['name' => 'Gravity-fed Irrigation',   'slug' => 'gravity-irrigation',       'color' => null, 'description' => 'No-pump water distribution.'],
            ['name' => 'Hydraulic Ram Pump',       'slug' => 'ram-pump',                 'color' => null, 'description' => 'Pump water with no electricity.'],
            ['name' => 'Greywater',                'slug' => 'greywater',                'color' => null, 'description' => 'Reuse of sink and shower water.'],
            ['name' => 'Constructed Wetland',      'slug' => 'constructed-wetland',      'color' => null, 'description' => 'Reed beds for treatment.'],
            ['name' => 'Compost Toilet',           'slug' => 'compost-toilet',           'color' => null, 'description' => 'Dry sanitation and nutrient cycling.'],

            // Natural building
            ['name' => 'Natural Building',         'slug' => 'natural-building',         'color' => null, 'description' => 'Cob, straw bale, adobe, timber.'],
            ['name' => 'Lime & Earthen Plasters',  'slug' => 'lime-earth-plaster',       'color' => null, 'description' => 'Breathable wall finishes.'],
            ['name' => 'Dry Stone',                'slug' => 'dry-stone',                'color' => null, 'description' => 'Mortarless retaining walls.'],
            ['name' => 'Timber Framing',           'slug' => 'timber-framing',           'color' => null, 'description' => 'Joinery and hand tools.'],

            // Materials / tools
            ['name' => 'Biochar',                  'slug' => 'biochar',                  'color' => null, 'description' => 'Charcoal for soil and carbon storage.'],
            ['name' => 'Sharpening & Hand Tools',  'slug' => 'hand-tools',               'color' => null, 'description' => 'Maintenance with files and stones.'],
            ['name' => 'Ropework & Knots',         'slug' => 'ropework-knots',           'color' => null, 'description' => 'Lashing, splicing and safety.'],
        ];

        $this->upsertTags($personTags, Tag::TYPE_PERSON);
        $this->upsertTags($helpTags, Tag::TYPE_GLOBAL);
        $this->upsertTags($lowtechTags, Tag::TYPE_GLOBAL);

        if (property_exists($this, 'command') && $this->command) {
            $this->command->info('Helpcenter: tags seeded (person + global + low-tech).');
        }
    }

    /**
     * Create or restore/update tags by (slug, type).
     */
    protected function upsertTags(array $items, string $type): void
    {
        foreach ($items as $t) {
            $slug = $t['slug'];
            $attrs = [
                'name'        => $t['name'],
                'slug'        => $slug,
                'type'        => $type,
                'color'       => $t['color']       ?? null,
                'description' => $t['description'] ?? null,
            ];

            $tag = Tag::withTrashed()->where('slug', $slug)->where('type', $type)->first();

            if ($tag) {
                if ($tag->trashed()) {
                    $tag->restore();
                }
                $tag->fill($attrs)->save();
            } else {
                Tag::create($attrs);
            }
        }
    }
}
