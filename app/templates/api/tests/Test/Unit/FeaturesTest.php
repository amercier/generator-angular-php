<?php

namespace Test\Unit;

use Api\Model\Features;

class FeaturesTest extends \PHPUnit_Framework_TestCase
{
    public function testGetFeaturesReturnsExpectedFeatures()
    {
        $allFeatures = array(
            'f1' => array('name' => 'feature 1', 'description' => 'description 1'),
            'f2' => array('name' => 'feature 2', 'description' => 'description 2'),
        );
        $features = new Features($allFeatures);
        $this->assertEquals(array(
            array('id' => 'f1', 'name' => 'feature 1', 'href' => './api/features/f1'),
            array('id' => 'f2', 'name' => 'feature 2', 'href' => './api/features/f2'),
        ), $features->getFeatures());
    }

    public function testGetFeatureReturnsExpectedFeature()
    {
        $allFeatures = array(
            'f1' => array('name' => 'feature 1', 'description' => 'description 1'),
            'f2' => array('name' => 'feature 2', 'description' => 'description 2'),
        );
        $features = new Features($allFeatures);
        $this->assertEquals(
            array(
                'id' => 'f1',
                'name' => 'feature 1',
                'description' => 'description 1',
                'href' => './api/features/f1',
            ),
            $features->getFeature('f1')
        );
        $this->assertEquals(
            array(
                'id' => 'f2',
                'name' => 'feature 2',
                'description' => 'description 2',
                'href' => './api/features/f2',
            ),
            $features->getFeature('f2')
        );
    }

    public function testGetUnknownFeatureReturnsNull()
    {
        $allFeatures = array(
            'f1' => array('name' => 'feature 1', 'description' => 'description 1'),
            'f2' => array('name' => 'feature 2', 'description' => 'description 2'),
        );
        $features = new Features($allFeatures);
        $this->assertEquals(null, $features->getFeature('f3'));
    }
}
