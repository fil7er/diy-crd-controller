<?

require '../vendor/autoload.php';
use K8sController;

class DummyGenerator
{

    protected string $website_url;

    public function __construct(string $website_url)
    {   
       
        $this->website_url = $website_url;
        $k8s = new K8sController();
        $k8s->createDeployment($this->getContents(), 'dummy-site');

    }


    public function getContents()
    {
        return file_get_contents($this->website_url);
    }




}