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
        $parser->setHook('math', 'DMathParse::mathTagHook' );
        
    }
    
    function dmathTagHook( $content, $attributes, $parser ) {
        
        $attributes['display'] = 'block';
        if ( array_key_exists( 'type', $attributes ) ) {
            $tag = $attributes['type'];
            $content = ' \\begin{'.$tag.'} '.$content.'\\end{'.$tag.'}';
        }
        $text = MathHooks::mathTagHook( $content, $attributes, $parser );
    
        $text[0] = Html::rawElement ('div', array( 'class' => 'math-wrapper' ), $text[0] );
        
        return $text;
    }
    
    function mathTagHook( $content, $attributes, $parser ) {
                
        $text = MathHooks::mathTagHook($content, $attributes, $parser);
        
        // the MathHooks::mathTagHooks function returns a array with some attributes, but we only want to change the text, which is at [0].
        $text[0] = Html::rawElement( 'span', array( 'class' => 'math-wrapper' ), $text[0] );
        
        return $text;
        
    }
    
}

?>