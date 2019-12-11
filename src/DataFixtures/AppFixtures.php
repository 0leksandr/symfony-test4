<?php

namespace App\DataFixtures;

use App\Entity\Characteristic;
use App\Entity\CharacteristicValue;
use App\Entity\Feedback;
use App\Entity\Product;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $product1 = $this->addProduct($manager, 'Acer notebook', 'img/acer.jpeg', 100);
        $product1->addFeedback(
            (new Feedback())
                ->setUsername('test_user')
                ->setTime(new DateTimeImmutable())
                ->setText('blah')
        );
        $product2 = $this->addProduct($manager, 'Asus notebook', 'img/asus.jpg', 150);
        for ($ii = 3; $ii < 50; $ii++) {
            $this->addProduct($manager, "Notebook №{$ii}", 'img/no-image.jpg', 100 + $ii);
        }

        $processor = (new Characteristic())->setName('Processor');
        $processor1 = (new CharacteristicValue())->setValue('Intel core i7');
        $processor2 = (new CharacteristicValue())->setValue('AMD');
        $processor
            ->addCharacteristicValue($processor1)
            ->addCharacteristicValue($processor2);
        $memory = (new Characteristic())->setName('Memory');
        $memory1 = (new CharacteristicValue())->setValue('500Gb');
        $memory->addCharacteristicValue($memory1);
        $manager->persist($processor);
        $manager->persist($memory);

        $product1
            ->addCharacteristicValue($processor1)
            ->addCharacteristicValue($memory1);
        $product2
            ->addCharacteristicValue($processor2)
            ->addCharacteristicValue($memory1);

        $manager->flush();
    }

    private function addProduct(
        ObjectManager $manager,
        string $name,
        string $image,
        float $price
    ): Product {
        $product = (new Product())
            ->setName($name)
            ->setImage($image)
            ->setPrice($price);
        $manager->persist($product);

        return $product;
    }
}
