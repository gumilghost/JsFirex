<?php

namespace App\Tests\Service;

use App\Service\PaginationHelper;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;

class PaginatorHelperTest extends KernelTestCase
{
    public function testCalculateTotalPages()
    {
        self::bootKernel();
        $container = self::$kernel->getContainer();

        $ph = new PaginationHelper($container->getParameter('resultsPerPage'));

        $this->assertEquals(
            $ph->calculateTotalPages(12),
            2
        );
    }

    public function testCalculateOffset()
    {
        self::bootKernel();
        $container = self::$kernel->getContainer();

        $ph = new PaginationHelper($container->getParameter('resultsPerPage'));

        $this->assertEquals(
            $ph->calculateOffset(2),
            10
        );
    }
}
