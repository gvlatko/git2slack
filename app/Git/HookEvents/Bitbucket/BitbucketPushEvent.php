<?php namespace App\Git\HookEvents\Bitbucket;

use App\Git\Data\Commits;
use App\Git\Data\Formatters\CommitsSlackFormatter;
use App\Git\HookEvents\ReportableGitEventInterface;
use Illuminate\Config\Repository as Config;

class BitbucketPushEvent extends BitbucketEvent implements ReportableGitEventInterface
{

    private $payload;
    /**
     * @var Config
     */
    private $config;

    /**
     * BitbucketPushEvent constructor.
     * @param $payload
     * @param Config $config
     */
    public function __construct($payload, Config $config)
    {
        parent::__construct($payload);
        $this->payload = $payload;
        $this->config = $config;
    }

    public function commits()
    {
        return new Commits(
            $this->payload["push"]["changes"][0]["commits"],
            $this->payload["push"]["changes"][0]["new"]["target"]["links"]["html"]["href"],
            $this->payload["push"]["changes"][0]["truncated"]
        );
    }

    /**
     * Generates a message about what happened in the event
     * @return mixed
     */
    public function report()
    {
        $formatter = new CommitsSlackFormatter($this->commits(), $this->sender(), $this->branch(), $this->repository());
        return $formatter->format();
    }
}