<?php
require_once __DIR__.'/../src/Skel.php';

/** @Schema(public) */
class SchemaAnnotationMock{}

/** @Connection(conn2) */
class ConnectionAnnotationMock{}

class FieldsAnnotationMock{
    /** @IntegerField */
    protected $int;

    /** @StringField */
    protected $str;

    /** @StringField(255) */
    protected $strMaxLen;

    /** @NotNull */
    protected $notNull;

    /** @DefaultValue(50) */
    protected $default;

    /** @ManyToManyField(TargetCls) */
    protected $manyToMany;

    /** @ForeignKey(TargetCls) */
    protected $fk;
}


class AnnotationsTest extends PHPUnit_Framework_TestCase{
    function test_annotation_can_map_schema(){
        $reflection = new ReflectionAnnotatedClass( 'SchemaAnnotationMock' );
        $annotations = $reflection->getAnnotations();
        $annotation = $annotations[0];

        $this->assertTrue( $annotation instanceof skel\annotations\Schema );
        $this->assertEquals( 'public', $annotation->value );
    }

    function test_annotation_can_map_connection(){
        $reflection = new ReflectionAnnotatedClass( 'ConnectionAnnotationMock' );
        $annotations = $reflection->getAnnotations();
        $annotation = $annotations[0];

        $this->assertTrue( $annotation instanceof skel\annotations\Connection );
        $this->assertEquals( 'conn2', $annotation->value );
    }

    function test_annotation_can_map_integerfield(){
        $reflection = new ReflectionAnnotatedProperty( 'FieldsAnnotationMock', 'int' );
        $annotations = $reflection->getAnnotations();
        $annotation = $annotations[0];

        $this->assertTrue( $annotation instanceof skel\annotations\IntegerField );
    }

    function test_annotation_can_map_stringfield_with_length(){
        $reflection = new ReflectionAnnotatedProperty( 'FieldsAnnotationMock', 'strMaxLen' );
        $annotations = $reflection->getAnnotations();
        $annotation = $annotations[0];

        $this->assertTrue( $annotation instanceof skel\annotations\StringField );
        $this->assertEquals( 255, $annotation->value );
    }

    function test_annotation_can_map_notnull(){
        $reflection = new ReflectionAnnotatedProperty( 'FieldsAnnotationMock', 'notNull' );
        $annotations = $reflection->getAnnotations();
        $annotation = $annotations[0];

        $this->assertTrue( $annotation instanceof skel\annotations\NotNull );
    }

    function test_annotation_can_map_default(){
        $reflection = new ReflectionAnnotatedProperty( 'FieldsAnnotationMock', 'default' );
        $annotations = $reflection->getAnnotations();
        $annotation = $annotations[0];

        $this->assertTrue( $annotation instanceof skel\annotations\DefaultValue );
        $this->assertEquals( 50, $annotation->value );
    }

    function test_annotation_can_map_many_to_many(){
        $reflection = new ReflectionAnnotatedProperty( 'FieldsAnnotationMock', 'manyToMany' );
        $annotations = $reflection->getAnnotations();
        $annotation = $annotations[0];

        $this->assertTrue( $annotation instanceof skel\annotations\ManyToManyField );
        $this->assertEquals( 'TargetCls', $annotation->value );
    }

    function test_annotation_can_map_many_to_fk(){
        $reflection = new ReflectionAnnotatedProperty( 'FieldsAnnotationMock', 'fk' );
        $annotations = $reflection->getAnnotations();
        $annotation = $annotations[0];

        $this->assertTrue( $annotation instanceof skel\annotations\ForeignKey );
        $this->assertEquals( 'TargetCls', $annotation->value );
    }
}