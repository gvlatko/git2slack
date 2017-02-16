<?php namespace App\Git\HookEvents\Gitlab;

use App\Git\Data\Branch;
use App\Git\Data\Commits;
use App\Git\Data\Formatters\CommitsSlackFormatter;
use App\Git\HookEvents\ReportableGitEventInterface;
use Illuminate\Config\Repository as Config;

class GitlabPushEvent extends GitlabEvent implements ReportableGitEventInterface
{

    private $payload;
    /**
     * @var Config
     */
    private $config;

    /**
     * GitlabPushEvent constructor.
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
            $this->payload["commits"],
            $this->repository()->url() . '/commit/' . $this->payload["after"]
        );
    }

    /**
     * Generates a message about what happened in the event
     * @return mixed
     */
    public function report()
    {
        // gitlab branch url is /reponame/tree/branchname
        $branch = new Branch('tree/' . $this->branch()->name());
        $formatter = new CommitsSlackFormatter($this->commits(), $this->sender(), $branch, $this->repository());
        return $formatter->format();
    }
}