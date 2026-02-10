<?php
function wrapperTag ($value,$tag = "p", $class = "")
{
 echo "<$tag class=$class>$value</$tag>";
}
