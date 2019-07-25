<?php

class posts
{
    private  $url;
    private $feedobject;
    
    /* Constructor to intialize class url value.*/
    function __construct($urlVal)
    {
        $this->url = $urlVal;
    }
    
    /* This function will return all the items  from the XML .*/
    function getItems()
    {
        try{
            
            $this->feedobject = new DOMDocument();
            $res  = $this->feedobject->load($this->url);
            if($res  == 1)
            {
                $contentItem = $this->feedobject->getElementsByTagName('item');
                return $contentItem;
            }
        }catch(DOMException $Exception){
            return null;
        }
        
        return null;
        
    }
    
    
    /* This function will create an array of feed to display on UI */
    function displayFeed($contentItem)
    {
        
        $feed = array();
        foreach ($contentItem as $node) {
            $item = array (
                'title' => $node->getElementsByTagName('title')->item(0)->nodeValue,
                'desc' => $node->getElementsByTagName('description')->item(0)->nodeValue,
                'content' => $node->getElementsByTagName('encoded')->item(0)->nodeValue,
                'link' => $node->getElementsByTagName('link')->item(0)->nodeValue,
                'date' => $node->getElementsByTagName('pubDate')->item(0)->nodeValue,
            );
            array_push($feed, $item);
        }
        
        /* we will call  the below function to display  each feed inside a div and display as per the user request*/
        
        $this->displayhtmlfeed($feed);
        
    }
    
    
    /* This function will return all the items  from the XML .*/
    function displayhtmlfeed($feed)
    {
        $max_item_cnt = count($feed);
        $result = "";
        
        for($x=0;$x<$max_item_cnt ;$x++)
        {
            
            /* create the div elemet for each feed but make sure to display the first feed visible*/
            if($x==0)
                $result = '<div class="mysite"  id="feedid'. $x .'"><ul class="feed-lists">';
                else
                    $result = '<div class="mysite" style="display:none" id="feedid'. $x .'"><ul class="feed-lists">';
                    
                    
                    
                    /*remove &amp; with &*/
                    $title = str_replace(' & ', ' &amp; ', $feed[$x]['title']);
                    
                    /*get the link url*/
                    $link = $feed[$x]['link'];
                    
                    /* add the heading with a link url in result */
                    $result .= '<div id="tit"><strong><a href="'.$link.'" target="_blank"  title="'.$title.'">'.$title.'</a></strong></div>';
                    
                    /* we will get the date format now*/
                    $date = date('l F d, Y', strtotime($feed[$x]['date']));
                    $result .= '<em>Posted on '.$date.'</em>';
                    
                    /* place the description now */
                    $description = $feed[$x]['desc'];
                    $content = $feed[$x]['content'];
                   
                    
                    // find the img
                    $has_image = preg_match('/<img.+src=[\'"](?P<src>.+?)[\'"].*>/i', $content, $image);
                    
                    // no html tags should be displayed
                    $description = filter_var($description, FILTER_SANITIZE_STRING);
                    
                    //remove ... from the description
                    $description = substr($description, 0, strpos($description, '...'));
                    
                    // add img if it exists
                    if ($has_image == 1) {
                        $result .= '<br><img class="feed-item-image" src="' . $image['src'] . '" /><br>';
                    }
                    
                    /* append description*/
                    
                    $result .= '<div class="feed-description">' . $description;
                    $result .= ' <a href="'.$link.'"  target="_blank" title="'.$title.'">Continue Reading..</a>'.'</div>';
                    
                    $result .= '<br></br>';
                    
                    $result .= '</ul></div>';
                    echo $result;
        }
        
        $this->displayhtmlfooter($max_item_cnt);
        
        
    }
    
    function displayhtmlfooter($max)
    {
        
        /*  use below code to create link for each feed on one page so that user can jump to any feed directly.
         * uncomment the below uncomment code to use this code.
         for ($vx=0 ;$vx < $max; $vx++)
         {
         $xvar= $vx+1;
         echo '<a href="posts.php?id=' . $vx . '" class="btn">' . $xvar . ' </a>';
         }*/
        
        /* more link to dislay feed one by one. code to display lies in javascript(myscript.js) file */
        echo '<a href="javascript:void(0)" class ="btn" id="moreid"">..More Feed..</a>';
        
    }
    
    
    
    
}
?>
