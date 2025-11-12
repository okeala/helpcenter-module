<?php

namespace Modules\Helpcenter\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Helpcenter\Models\Address;
use MatanYadaev\EloquentSpatial\Objects\Point;

class AddressFactory extends Factory
{
    protected $model = Address::class;

    public function definition(): array
    {
        return [
            'line1'        => $this->faker->streetAddress(),
            'line2'        => null,
            'city'         => 'Covilhã',
            'region'       => 'Castelo Branco',
            'postal_code'  => (string) $this->faker->numberBetween(6200, 6299),
            'country_code' => 'PT',
            // 'location' défini dans les states ci-dessous
        ];
    }

    /** BBox Covilhã–Belmonte */
    public function nearCovilha(): static
    {
        $latMin = 40.25; $latMax = 40.40;
        $lngMin = -7.60; $lngMax = -7.30;

        $lat = $latMin + lcg_value() * ($latMax - $latMin);
        $lng = $lngMin + lcg_value() * ($lngMax - $lngMin);

        return $this->state(fn () => [
            'location' => new Point($lat, $lng, 4326),
        ]);
    }

    /**
     * QAPAS (résidents) — adresse fixe + coords configurables.
     * Renseigne env/config si possible :
     *   config('qapas.hq.lat'), config('qapas.hq.lng')
     */
    public function qapas(): static
    {
        $lat = (float) (config('qapas.hq.lat') ?? env('QAPAS_HQ_LAT', 40.330000));
        $lng = (float) (config('qapas.hq.lng') ?? env('QAPAS_HQ_LNG', -7.470000));

        return $this->state(fn () => [
            'line1'        => 'Quinta do Arco',
            'line2'        => 'Perto da capela',
            'city'         => 'Aldeia do Souto',
            'region'       => 'Covilhã',
            'postal_code'  => '6250-501',
            'country_code' => 'PT',
            'location'     => new Point($lat, $lng, 4326),
        ]);
    }

    /** Point explicite */
    public function at(float $lat, float $lng): static
    {
        return $this->state(fn () => [
            'location' => new Point($lat, $lng, 4326),
        ]);
    }
}
