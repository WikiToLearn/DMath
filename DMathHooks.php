<?php

if (!defined('MEDIAWIKI')){
    die();
}

class DMathParse {
    
    function onParserFirstCallSetup(Parser $parser) {
    
        if(!ExtensionRegistry::getInstance()->isLoaded('Math')) {
            die("The DMath extension requires the Math extension, please include it.");
        }
    
        $parser->setHook('dmath', 'DMathParse::dmathTagHook' );
        
    }
    
    function dmathTagHook( $content, $attributes, $parser ) {
        
        $attributes['display'] = 'block';
        if ( array_key_exists( 'type', $attributes ) ) {
            $tag = $attributes['type'];
            $content = ' \\begin{'.$tag.'} '.$content.'\\end{'.$tag.'}';
        }
        return MathHooks::mathTagHook($content, $attributes, $parser);
    }
}

?>