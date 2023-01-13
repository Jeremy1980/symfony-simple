<?php
namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

// 1. Import the ORM EntityManager Interface
use Doctrine\ORM\EntityManagerInterface;

class CollectPostsCommand extends Command
{
    protected static $defaultName = 'app:collect-posts';

    // 2. Expose the EntityManager in the class level
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        // 3. Update the value of the private entityManager variable through injection
        $this->entityManager = $entityManager;

        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $em = $this->entityManager;

        // 4. Access repositories
        $repoP = $em->getRepository("App\Entity\Post");
        $repoU = $em->getRepository("App\Entity\User");

        $content = file_get_contents('https://jsonplaceholder.typicode.com/posts');
        $posts = json_decode($content, true);

        $content = file_get_contents('https://jsonplaceholder.typicode.com/users');
        $users = json_decode($content, true);

        if (empty($posts) || empty($users))
        {
            return Command::FAILURE;
        }

        // 5. Use regular methods.
        foreach($posts as $data)
        {
          $repoU->find($data['userId']) && $repoP->insert($data);
        }
        $em->flush();

        return Command::SUCCESS;
    }
}
?>