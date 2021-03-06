<?php
/**
 * @package     Mautic
 * @copyright   2014 Mautic Contributors. All rights reserved.
 * @author      Mautic
 * @link        http://mautic.org
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

namespace Mautic\CoreBundle\Event;

use Symfony\Component\EventDispatcher\Event;

/**
 * Class SidebarCanvasEvent
 */
class SidebarCanvasEvent extends Event
{
    /**
     * @var array
     */
    private $sections = array('header', 'footer', 'content');

    /**
     * @var array
     */
    private $left  = array();

    /**
     * @var array
     */
    private $right = array();

    /**
     * @var
     */
    private $templating;

    /**
     * @var array
     */
    private $main  = array();

    public function __construct($templating)
    {
        $this->templating = $templating;
    }

    /**
     * Insert content into left canvas
     *
     * @param array $sections
     */
    public function pushToLeftCanvas(array $sections)
    {
        $this->setCanvasSection('left', $sections);
    }

    /**
     * Insert content into right canvas
     *
     * @param array $sections
     */
    public function pushToRightCanvas(array $sections)
    {
        $this->setCanvasSection('right', $sections);
    }

    /**
     * Insert content into main canvas
     *
     * Note that header is not allowed for main
     *
     * @param array $sections
     */
    public function pushToMainCanvas(array $sections)
    {
        $this->setCanvasSection('main', $sections);
    }

    /**
     * @param $canvas
     * @param $sections
     */
    private function setCanvasSection($canvas, $sections)
    {
        $canvasSections = array();
        foreach ($this->sections as $section) {
            $canvasSections[$section] = (isset($sections[$section])) ? $sections[$section] : '';
        }

        $this->{$canvas} = $canvasSections;
    }

    /**
     * Get the canvas sections
     *
     * @param null $canvas
     *
     * @return array
     */
    public function getCanvasContent($canvas = null)
    {
        if ($canvas) {
            return $this->$canvas;
        } else {
            return array(
                'left'  => $this->left,
                'right' => $this->right,
                'main'  => $this->main
            );
        }
    }

    /**
     * @return mixed
     */
    public function getTemplating()
    {
        return $this->templating;
    }
}
