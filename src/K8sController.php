<?php

require '../vendor/autoload.php';
use RenokiCo\PhpK8s\KubernetesCluster;
use RenokiCo\PhpK8s\K8s;

class K8sController
{

    protected KubernetesCluster $cluster;

    public function __construct()
    {
        // Create a new instance of KubernetesCluster.
        $this->cluster = KubernetesCluster::fromUrl('http://127.0.0.1:8080'); //set kubectl proxy first
        $this->cluster->namespace()->setName('dummy')->create();
        $this->cluster->isSynced(); // true

    }

    /**
     * Create Service in kubernetes Cluster for dummy website
     */
    public function createService(String $serviceName)
    {

        try
        {
            $svc = $this->cluster->service()
            ->setName($serviceName)
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


    public function createDeployment(String $webContent, String $deployName)
    {

        try
        {
            $container = K8s::container()
            ->setName($deployName)
            ->setImage('httpd', '2.4')
            ->setEnv(['DummySite' => $webContent])
            ->setCommand(['echo', $webContent, ">>", "/usr/local/apache2/htdocs/index.html"])
            ->setPorts([
                ['name' => $deployName, 'protocol' => 'TCP', 'containerPort' => 80],
            ]);

            $pod = K8s::pod()
                ->setName($deployName)
                ->setLabels(['tier' => 'backend'])
                ->setContainers([$container]);

            $dep = $this->cluster
                ->deployment()
                ->setName($deployName)
                ->setSelectors(['matchLabels' => ['tier' => 'backend']])
                ->setReplicas(1)
                ->setTemplate($pod)
                ->create();
        }
        catch(Exception $e)
        {
            throw $e;
        }

    }

}