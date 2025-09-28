<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class VegetableControllerTest extends WebTestCase
{
    public function testCreateVegetable(): void
    {
        $client = static::createClient();
        $client->request('POST', '/vegetables', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode([
                                                                                                                'name' => 'Testowa Marchew',
                                                                                                                'type' => 'korzeniowe',
                                                                                                                'season' => 'jesień',
                                                                                                                'description' => 'Opis testowy',
                                                                                                            ]));

        $this->assertResponseStatusCodeSame(201);
        $this->assertJson($client->getResponse()->getContent());
    }

    public function testGetVegetables(): void
    {
        $client = static::createClient();
        $client->request('GET', '/vegetables');

        $this->assertResponseIsSuccessful();
        $this->assertJson($client->getResponse()->getContent());
    }

    public function testUpdateVegetable(): void
    {
        $client = static::createClient();

        $client->request('POST', '/vegetables', [], [],
                         ['CONTENT_TYPE' => 'application/json'], json_encode([
                                                                                'name' => 'Do aktualizacji',
                                                                                'type' => 'liściaste',
                                                                                'season' => 'wiosna',
                                                                            ]));

        $this->assertResponseStatusCodeSame(201);
        $data = json_decode($client->getResponse()->getContent(), true);
        $id = $data['id'];

        $client->request('PUT', "/vegetables/{$id}", [], [], ['CONTENT_TYPE' => 'application/json'], json_encode([
                                                                                                                     'name' => 'Zmieniona nazwa',
                                                                                                                 ]));

        $this->assertResponseIsSuccessful();
        $this->assertStringContainsString('updated', $client->getResponse()->getContent());
    }

    public function testDeleteVegetable(): void
    {
        $client = static::createClient();

        $client->request('POST', '/vegetables', [], [],
                         ['CONTENT_TYPE' => 'application/json'], json_encode([
                                                                                'name' => 'Do usunięcia',
                                                                                'type' => 'strączkowe',
                                                                                'season' => 'lato',
                                                                            ]));

        $this->assertResponseStatusCodeSame(201);
        $data = json_decode($client->getResponse()->getContent(), true);
        $id = $data['id'];

        $client->request('DELETE', "/vegetables/{$id}");
        $this->assertResponseIsSuccessful();
        $this->assertStringContainsString('deleted', $client->getResponse()->getContent());
    }
}
