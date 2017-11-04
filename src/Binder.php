<?php declare(strict_types=1);

namespace Ellipse;

use Ellipse\Binder\Project;
use Ellipse\Binder\ServiceProviderCollection;

class Binder
{
    /**
     * The project.
     *
     * @var \Ellipse\Binder\Project
     */
    private $project;

    /**
     * Return a binder with the given project root path.
     *
     * @param string $root
     * @return Ellipse\Binder
     */
    public static function newInstance(string $root): Binder
    {
        $project = Project::newInstance($root);

        return new Binder($project);
    }

    /**
     * Set up a binder with the given project.
     *
     * @param \Ellipse\Binder\Project $project
     */
    public function __construct(Project $project)
    {
        $this->project = $project;
    }

    /**
     * Return an array of service providers built from the project manifest file
     * definitions.
     *
     * @return array
     */
    public function providers(): array
    {
        $manifest = $this->project->manifest();

        $list = new ServiceProviderCollection($manifest);

        return $list->toArray();
    }
}
