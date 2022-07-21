<?



class DummyGenerator
{

    protected string $website_url;

    public function __construct(string $website_url)
    {   
        
        $this->website_url = $website_url;

    }


    public function getContents()
    {
        return file_get_contents($this->website_url);
    }

}