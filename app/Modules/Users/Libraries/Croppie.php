<?php

namespace App\Modules\Users\Libraries;

class Croppie
{
    private $id;
    private $oid;
    private $reference = "DEFAULT";
    private $type = "rectangle";
    private $image = false;

    private $viewport_width = 720;
    private $viewport_height = 480;

    private $boundary_width = 740;
    private $boundary_height = 500;

    private $output_width = null;
    private $output_height = null;
    
    private $default_image = "/themes/assets/images/empty-720x480.png";
    private $fieldName = "attachment";
    private $url;

    private $html = [];

    /**
     * Constructor de la clase
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->id = $attributes['id'] ?? uniqid('croppie_');
        $this->oid = $attributes['oid'] ?? 0;
        
        if (isset($attributes['viewport'])) {
            $this->viewport_width = $attributes['viewport']['width'];
            $this->viewport_height = $attributes['viewport']['height'];
            $this->type = $attributes['viewport']['type'] ?? 'square';
        }
        
        if (isset($attributes['boundary'])) {
            $this->boundary_width = $attributes['boundary']['width'];
            $this->boundary_height = $attributes['boundary']['height'];
        }

        if (isset($attributes['output'])) {
            $this->output_width = $attributes['output']['width'];
            $this->output_height = $attributes['output']['height'];
        }

        $this->url = "/storage/images/croppie/{$this->oid}";
        
        $js = base_url("/themes/assets/libraries/croppie/croppie.js?" . time());
        $css = base_url("/themes/assets/libraries/croppie/croppie.css");
        
        $this->add_Html("<link rel=\"stylesheet\" href=\"{$css}\" type=\"text/css\">");
        $this->add_Html("<script type=\"text/javascript\" charset=\"utf-8\" src=\"{$js}\"></script>");
    }

    private function add_Html($html)
    {
        $this->html[] = $html;
    }

    /**
     * Permite establecer o modificar la ruta de almacenamiento de la imagen a cargar
     * @param string $src
     */
    public function set_Image($src)
    {
        if (!empty($src)) {
            $this->default_image = $src;
            $this->image = $src;
        }
    }

    /**
     * Permite establecer o modificar la referencia
     * @param string $reference
     */
    public function set_Reference($reference)
    {
        $this->reference = $reference;
    }

    /**
     * Permite establecer o modificar la ruta ajax
     * @param string $path
     */
    public function set_Ajax($path)
    {
        $this->url = $path;
    }

    public function __toString()
    {
        $data = [
            'id' => $this->id,
            'oid' => $this->oid,
            'reference' => $this->reference,
            'default_image' => $this->image ?: $this->default_image,
            'viewport_width' => $this->viewport_width,
            'viewport_height' => $this->viewport_height,
            'boundary_width' => $this->boundary_width,
            'boundary_height' => $this->boundary_height,
            'output_width' => $this->output_width,
            'output_height' => $this->output_height,
            'type' => $this->type,
            'url' => $this->url,
            'fieldName' => $this->fieldName,
            'csrfName' => csrf_token(),
            'csrfHash' => csrf_hash(),
        ];

        // Render the view
        $viewContent = view('App\Views\_Tools\croppie', $data);
        
        $this->add_Html($viewContent);

        return implode("\n", $this->html);
    }
}