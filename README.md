SimpleMetadataBundle
====================

Symfony2 simple metadata bundle


Installation
------------

To install this bundle please follow the next steps:

First add the dependency in your `composer.json` file:

```json
"require": {
        ...,
        "idci/simple-metadata-bundle": "dev-master"
    },
```

Then install the bundle with the command:

```sh
php composer update
```

Enable the bundle in your application kernel:

```php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        ...
        new IDCI\Bundle\SimpleMetadataBundle\IDCISimpleMetadataBundle(),
    );
}
```

Now import the bundle configuration in your `app/config/config.yml`

```yml
imports:
    ...
    - { resource: @IDCISimpleMetadataBundle/Resources/config/config.yml }
```

Now the Bundle is installed and configured.


How to use
----------

### OneToOne Relation with a metadata:

In your entity:

```php
/**
 * @var Metadata
 *
 * @ORM\OneToOne(targetEntity="IDCI\Bundle\SimpleMetadataBundle\Entity\Metadata", cascade={"all"})
 * @ORM\JoinColumn(name="metadata_id", referencedColumnName="id", onDelete="SET NULL", nullable=true)
 */
private $metadata;
```

In this entity form type:

```php
public function buildForm(FormBuilderInterface $builder, array $options)
{
    $builder
        ...
        ->add('metadata', 'related_to_one_metadata', array(
            'data' => $builder->getData()->getMetadata()
        ))
        ...
    ;
}
```

### ManyToMany Relation with a metadata:

In your entity:

```php
/**
 * @var array<Metadata>
 *
 * @ORM\ManyToMany(targetEntity="IDCI\Bundle\SimpleMetadataBundle\Entity\Metadata", cascade={"all"})
 * @ORM\JoinTable(name="my_entity_metadata",
 *     joinColumns={@ORM\JoinColumn(name="my_entity_id", referencedColumnName="id", onDelete="cascade")},
 *     inverseJoinColumns={@ORM\JoinColumn(name="metadata_id", referencedColumnName="id", unique=true, onDelete="cascade")}
 * )
 */
private $metadatas;
```

In this entity form type:

```php
public function buildForm(FormBuilderInterface $builder, array $options)
{
    $builder
        ...
        ->add('metadatas', 'related_to_many_metadata')
        ...
    ;
}
```

### Without metadata entity relation:

In your entity:

```php
/**
 * @var string
 *
 * @ORM\Column(name="metadata", type="textarea")
 */
private $metadata;
```

In this entity form type:

```php
public function buildForm(FormBuilderInterface $builder, array $options)
{
    $builder
        ...
        ->add('metadata', 'metadata')
        ...
    ;
}
```
