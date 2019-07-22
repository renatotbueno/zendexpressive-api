# Direction

Documento de referência para desenvolvedores se localizarem quanto aos padrões
utilizados na arquitetura e desenvolvimento do projeto **Direction**.

### Visão Geral
- As camadas de apresentação só conversam com o core por meio de **Services**;
- Todas as configurações devem ser setadas por meio de **variáveis de ambiente**, elas serão passadas para o sistema pelo arquivo *config/autoload/global.php*, sendo sendo enviadas para as camadas mais baixas por meio de injeção de dependência;
- Usamos Docker para normalizar o ambiente de desenvolvimento, para iniciar o sistema é só executar **docker-compose up** na raiz do projeto;
- Todos os binários devem ficar na pasta bin/ na raiz;
- A aplicação não deve gravar logs na mesma estrutura, deve enviar para o sistema operacional gravar em arquivo ou enviar para um centralizador como ELK;
- Sempre tentar identificar e criar Value Objects para facilitar o entendimento do código e evitar validações duplicadas, mas sempre ponderar se há mesmo essa necessidade pois a quantidade de objetos na memório tem relação direta com a performance;
- Todas as alteração de banco de dados devem ser feitas por meio de Migrations;
- Utilizamos o Doctrine como ORM.


### Estrutura básica de um Bounded Context do sistema:
*Podem ser sistemas totalmente distintos mas no nosso caso serão a separação de contextos na mesma aplicação, isso facilitará a migração para outros modelos como SOA e Microsserviços quando houver necessidade. Segue Definição, para mais referências sobre assunto ler livros de DDD do Eric Evans e Vaughn Vernon: https://martinfowler.com/bliki/BoundedContext.html*

```
├── Direction
    │   ├── Application
    │   │   ├── Command
    │   │   │   └── DirectionProtheus.php
    │   │   └── Handler
    │   │       └── DirectionProtheusCommandHandler.php
    │   ├── Domain
    │   │   ├── Entity
    │   │   │   └── Direction.php
    │   │   ├── Event
    │   │   │   └── DirectionCreated.php
    │   │   ├── Repository
    │   │   │   └── DirectionRepositoryInterface.php
    │   │   └── Exception
    │   │       └── DirectionDomainException.php
    │   │ 
    │   └── Infrastructure
    │       ├── Persistence
    │       │   ├── Doctrine
    │       │   │   ├── ORM
    │       │   │   │   └── Direction.Domain.Entity.Direction.dcm.yml 
    │       │   │   ├── Repository  
    │       │   │   │   └── DoctrineDirectionRepository.php
    │       │   │   │       
    │       │   │   │ 
```

- **Direction > Application > Command** - Ficam os Use Cases ou em outras palavras, mensagens que determinam uma intenção de um usuário, bot, fila, ou terminal. Devem ser capturados nas reuniões com a equipe de negócio.
- **Direction > Application > Handler** - Ficam os *Command handlers* trabalham como uma camada de serviço no padrão MVCS, podem tanto tratar um command quanto vários do mesmo contexto.
- **Direction > Domain > Entity** - Model - Agregates (Entidades Raiz, geralmente os UseCases dizem respeito a ela) e entities e Value Object.
- **Direction > Domain > Event** - Todos os eventos que ocorrem nesse contexto, são produzidos pelas Agregados ou Entidades.
- **Direction > Domain > Repository** - Interfaces que representam como devem ser os Repositories desse contexto, a camada de infraestrutura implementa eles para fornecedor a classe concreta faz as requisições para serviços de apoio tais como: Banco de Dados, APIs.
- **Direction > Infrastruture** - É um módulo de algum framework, nesse caso ZF3, nessa camada não há necessidade de ter controllers ou views, somente as implementações de Repositories, Comunicação com serviços externos, apis de terceiros, sistemas de mensageria, etc.

### Práticas e Frameworks

 - 12FactorApp - https://12factor.net/pt_br/
 - ZendFramework
 - DDD - Domain Driven Design
   * Referências:
     * Eric Evans https://domainlanguage.com/
     * Vaughn Vernon https://vaughnvernon.co/
     * Martin Fowler https://martinfowler.com/
    
 - BDD e TDD - Behavior Driven Development e Test Driven Development
    * Behat
    * PhpUnit    
    
 - SOLID
 - PSR2
 - Object Calisthenics
 - Design Patterns
 - Zend Framework 3 para camada de Infraestrutura e Apresentação
 
 
### Padrões Arquiteturais

 - Hexagonal Arquitecture
   * Também conhecida como Ports/Adapters ou Onion Arquicteture. É uma padrão de arquitetura que consiste em isolar as camadas de níveis mais baixas das camadas de níveis mais altas.
    O Core deve ser totalmente agnóstico de framework, apresentação ou serviços de infraestrutura como Banco de Dadosm, Serviços de Mensageria, etc...
   * A Camada de Domínio deve trabalhar apenas objetos em memória, ela tem a responsabilidade de definir as entidades que deverão ser implementadas na camada de infraestrutura.
   
 - CQRS - https://martinfowler.com/bliki/CQRS.html, http://www.eduardopires.net.br/2016/07/cqrs-o-que-e-onde-aplicar/, http://cqrs.nu/
    * Toda aplicação segue um fluxo para alteração de estado e outro para leitura
    * Dentro da pasta Application deve conter a pasta Command e a pasta Handler
      * Commands devem mostrar a intenção do usuário (Web, Cli, API, Mensageria)
      * CommandHandlers são a nossa camada de serviço, ela possui métodos para receber os commandos no seguinte padrão: 
        ```php 
        // Para facilitar o desenvolvimento, vamos utilizar uma solução open-source para auxiliar a implementação de padrão
        // A princípio foi escolhida a biblioteca Broadway https://github.com/broadway. Ela possui tanto recursos para CQRS quanto para EventSource
        // Sendo assim o métodos para executar os commands seguem a seguinte convenção:   
            
            class TrackingCommandHandler  
            {
                public function handleTrackingCommand(TrackingCommand $command) ...
            }
        ```
        
 - Domain Event
   * Cada entidade deve ser responsável por lançar eventos de alterações relevantes de estado na aplicação
   

Tirando isso você pode desenvolver da forma que preferir :)


## Descrição Infraestrutura:

### RDS

### EC2
 - máquina produção auto-scaling (c4.large)
 
### Redis

### SQS
 - https://sqs.sa-east-1.amazonaws.com/683720833731/
 
### ELK

### Modulos PHP
 - bz2
 - calendar
 - ctype
 - curl
 - dom
 - exif
 - fileinfo
 - ftp
 - gettext
 - iconv
 - json
 - mbstring
 - mcrypt
 - mysqlnd
 - pdo
 - phar
 - simplexml
 - soap
 - sockets
 - sqlite3
 - tokenizer
 - xml
 - xmlwriter
 - xsl
 - mysqli
 - pdo_mysql
 - pdo_sqlite
 - wddx
 - xmlreader
 - igbinary
 - redis
 - sqlsrv
 - pdo_sqlsrv

#### Contribuidores

- Ricardo Marangoni da Mota
- Renato Teixeira Bueno
