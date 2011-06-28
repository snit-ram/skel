<?php
namespace skel\annotations;

use Annotation;

class IntegerField extends Annotation{}
class StringField extends Annotation{}
class ForeignKey extends Annotation{}
class ManyToManyField extends Annotation{}

class NotNull extends Annotation{}
class DefaultValue extends Annotation{}