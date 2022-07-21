<?
use RenokiCo\PhpK8s\KubernetesCluster;

// Create a new instance of KubernetesCluster.
$cluster = KubernetesCluster::fromUrl('http://127.0.0.1:8080');

// Create a new NGINX service.
$svc = $cluster->service()
    ->setName('nginx')
    ->setNamespace('frontend')
    ->setSelectors(['app' => 'frontend'])
    ->setPorts([
        ['protocol' => 'TCP', 'port' => 80, 'targetPort' => 80],
    ])
    ->create();