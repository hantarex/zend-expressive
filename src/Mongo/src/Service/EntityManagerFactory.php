<?php
/*
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the MIT license. For more information, see
 * <http://www.doctrine-project.org>.
 */

namespace Mongo\Service;

use Doctrine\ORM\EntityManager;
use DoctrineModule\Service\AbstractFactory;
use DoctrineORMModule\Options\EntityManager as DoctrineORMModuleEntityManager;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class EntityManagerFactory extends AbstractFactory
{
    public function __construct()
    {
        parent::__construct("test");
    }

    /**
     * {@inheritDoc}
     *
     * @return EntityManager
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /* @var $options DoctrineORMModuleEntityManager */
        $options    = $this->getOptions($container, 'entitymanager');
        $connection = $container->get($options->getConnection());
        $config     = $container->get($options->getConfiguration());

        // initializing the resolver
        // @todo should actually attach it to a fetched event manager here, and not
        //       rely on its factory code
        $container->get($options->getEntityResolver());

        return EntityManager::create($connection, $config);
    }

    /**
     * {@inheritDoc}
     * @return EntityManager
     */
    public function createService(ServiceLocatorInterface $container)
    {
        return $this($container, EntityManager::class);
    }

    /**
     * {@inheritDoc}
     */
    public function getOptionsClass()
    {
        return DoctrineORMModuleEntityManager::class;
    }
}