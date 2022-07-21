<?php

require '../vendor/autoload.php';
use RenokiCo\PhpK8s\KubernetesCluster;

class K8sController
{

    protected KubernetesCluster $cluster;

    public function __construct()
    {
        // Create a new instance of KubernetesCluster.
        $this->cluster = KubernetesCluster::fromUrl('http://127.0.0.1:8080'); //set kubectl proxy first

    }

    /**
     * Create Service in kubernetes Cluster for dummy website
     */
    private function createService(String $serviceName)
    {

        try
        {
            $svc = $this->cluster->service()
            ->setName($serviceName)
            ->setNamespace('crd-namespace') 
            ->setPorts([
                ['protocol' => 'TCP', 'port' => 80, 'targetPort' => 80],
        ])
        ->create();
        }

        catch (Exception $e)

        {
            throw $e;
        }

    }


    private function createDeployment(String $deployName)
    {

        try
        {
            $svc = $this->cluster->deployment()
            ->setName($deployName)
            ->setNamespace('crd-namespace')
            ->create();
        }
        catch(Exception $e)
        {
            throw $e;
        }

    }

}