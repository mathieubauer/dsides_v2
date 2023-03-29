<?php

namespace App\Factory;

use App\Entity\AboutUs;
use App\Repository\AboutUsRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<AboutUs>
 *
 * @method        AboutUs|Proxy create(array|callable $attributes = [])
 * @method static AboutUs|Proxy createOne(array $attributes = [])
 * @method static AboutUs|Proxy find(object|array|mixed $criteria)
 * @method static AboutUs|Proxy findOrCreate(array $attributes)
 * @method static AboutUs|Proxy first(string $sortedField = 'id')
 * @method static AboutUs|Proxy last(string $sortedField = 'id')
 * @method static AboutUs|Proxy random(array $attributes = [])
 * @method static AboutUs|Proxy randomOrCreate(array $attributes = [])
 * @method static AboutUsRepository|RepositoryProxy repository()
 * @method static AboutUs[]|Proxy[] all()
 * @method static AboutUs[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static AboutUs[]|Proxy[] createSequence(iterable|callable $sequence)
 * @method static AboutUs[]|Proxy[] findBy(array $attributes)
 * @method static AboutUs[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static AboutUs[]|Proxy[] randomSet(int $number, array $attributes = [])
 *
 * @phpstan-method        Proxy<AboutUs> create(array|callable $attributes = [])
 * @phpstan-method static Proxy<AboutUs> createOne(array $attributes = [])
 * @phpstan-method static Proxy<AboutUs> find(object|array|mixed $criteria)
 * @phpstan-method static Proxy<AboutUs> findOrCreate(array $attributes)
 * @phpstan-method static Proxy<AboutUs> first(string $sortedField = 'id')
 * @phpstan-method static Proxy<AboutUs> last(string $sortedField = 'id')
 * @phpstan-method static Proxy<AboutUs> random(array $attributes = [])
 * @phpstan-method static Proxy<AboutUs> randomOrCreate(array $attributes = [])
 * @phpstan-method static RepositoryProxy<AboutUs> repository()
 * @phpstan-method static list<Proxy<AboutUs>> all()
 * @phpstan-method static list<Proxy<AboutUs>> createMany(int $number, array|callable $attributes = [])
 * @phpstan-method static list<Proxy<AboutUs>> createSequence(iterable|callable $sequence)
 * @phpstan-method static list<Proxy<AboutUs>> findBy(array $attributes)
 * @phpstan-method static list<Proxy<AboutUs>> randomRange(int $min, int $max, array $attributes = [])
 * @phpstan-method static list<Proxy<AboutUs>> randomSet(int $number, array $attributes = [])
 */
final class AboutUsFactory extends ModelFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function getDefaults(): array
    {
        return [
            'content' => self::faker()->paragraphs(8, true),
            'reference_page' => 'about us',
            'is_published' => true,
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(AboutUs $aboutUs): void {})
        ;
    }

    protected static function getClass(): string
    {
        return AboutUs::class;
    }
}
