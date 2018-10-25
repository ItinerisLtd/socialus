<?php
declare (strict_types = 1);

namespace Itineris\Socialus;

class Socialus
{
    /**
     * Default settings
     *
     * @var array
     */
    protected $defaults = [
        'container_element' => 'ul',
        'container_class' => 'social-list',
        'item_element' => 'li',
        'item_class' => '',
        'link_class' => '',
        'screen_reader_class' => 'sr-only',
        'type' => 'icon',
        'sites' => [
            'facebook' => [
                'link' => 'https://www.facebook.com/sharer/sharer.php',
                'params' => [
                    'url' => 'u',
                    'title' => 'quote',
                ],
                'label' => 'Facebook',
                'icon' => 'fa fa-facebook-official',
                'image' => '',
            ],
            'twitter' => [
                'link' => 'https://twitter.com/intent/tweet',
                'params' => [
                    'url' => 'source',
                    'title' => 'text',
                ],
                'label' => 'Twitter',
                'icon' => 'fa fa-twitter',
                'image' => '',
            ],
            'google-plus' => [
                'link' => 'https://plus.google.com/share',
                'params' => [
                    'url' => 'url',
                ],
                'label' => 'Google Plus',
                'icon' => 'fa fa-google-plus',
                'image' => '',
            ],
            'linkedin' => [
                'link' => 'http://www.linkedin.com/shareArticle?mini=true',
                'params' => [
                    'url' => 'url',
                    'title' => 'title',
                ],
                'label' => 'LinkedIn',
                'icon' => 'fa fa-linkedin',
                'image' => '',
            ],
            'email' => [
                'link' => 'mailto:',
                'params' => [
                    'title' => 'subject',
                ],
                'label' => 'Email',
                'icon' => 'fa fa-envelope',
                'image' => '',
            ],
        ],
    ];

    /**
     * Merged settings
     *
     * @var array
     */
    protected $data;

    /**
     * The URL to share
     *
     * @var string
     */
    protected $url;

    /**
     * The title of the URL to share
     *
     * @var string
     */
    protected $title;

    public function __construct(array $data = [])
    {
        $this->url = $this->currentUrl();
        $this->title = $this->currentTitle();
        $this->data = array_merge($this->defaults, $data);
    }

    /**
     * Set the URL to share
     *
     * @param string $url The URL to share.
     * @return void
     */
    public function setUrl(string $url): void
    {
        $this->url = esc_url($url);
    }

    /**
     * Get the URL to share
     *
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * Get the encoded sharable URL for use with HTML attributes
     *
     * @return string
     */
    public function getUrlEncoded(): string
    {
        return rawurlencode($this->getUrl());
    }

    /**
     * Set the title to share
     *
     * @param string $title The title of the URL to share.
     * @return void
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * Get the title of the URL to share
     *
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Get the encoded title of the URL to share
     *
     * @return string
     */
    public function getTitleEncoded(): string
    {
        return rawurlencode($this->getTitle());
    }

    /**
     * Get a setting
     *
     * @param string $key The setting to get.
     * @return mixed
     */
    public function get(string $key)
    {
        return $this->data[$key] ?? null;
    }

    /**
     * Adds a social site to the sites list
     *
     * @param string $site The social site to add.
     * @param array  $data The data to add.
     * @return void
     */
    public function addSite(string $site, array $data): void
    {
        $this->data['sites'][$site] = $data;
    }

    /**
     * Removes a social site from the sites list
     *
     * @param string $site The social site to remove.
     * @return void
     */
    public function removeSite(string $site): void
    {
        unset($this->data['sites'][$site]);
    }

    /**
     * Generate the current title via WordPress methods
     *
     * @return string
     */
    private function currentTitle(): string
    {
        if (is_home()) {
            $home = get_option('page_for_posts', true);
            if ($home) {
                return get_the_title($home);
            }
            return 'Latest Posts';
        }
        if (is_front_page()) {
            $front_page = get_option('page_on_front', true);
            if ($front_page) {
                return get_the_title($front_page);
            }
            return 'Home';
        }
        if (is_archive()) {
            return get_the_archive_title() ? : 'Archive';
        }
        if (is_search()) {
            return sprintf('Search Results for %s', get_search_query());
        }
        if (is_404()) {
            return 'Not Found';
        }
        return get_the_title();
    }

    /**
     * Get the WordPress site URL
     *
     * @return string
     */
    private function siteUrl(): string
    {
        return get_home_url();
    }

    /**
     * Generate the current URL via WordPress methods
     *
     * @return string
     */
    private function currentUrl(): string
    {
        return $this->siteUrl() . add_query_arg(null, null) ? : $this->siteUrl();
    }

    /**
     * Get the page description using WordPress and Yoast SEO methods
     * TODO: Implement this for descriptions params like on LinkedIn
     *
     * @see https://github.com/Yoast/wordpress-seo/blob/trunk/frontend/class-opengraph.php#L554-L626
     * @param mixed $post_id The post or post ID.
     * @return string
     */
    private function currentPageMetaDescription($post_id): string
    {
        $post = get_post($post_id);
        $ogdesc = \WPSEO_Meta::get_value('opengraph-description', $post_id);
        $ogdesc = wpseo_replace_vars($ogdesc, $post);

        if ('' === $ogdesc) {
            $ogdesc = \WPSEO_Frontend::get_instance()->metadesc(false);
        }

        if (! is_string($ogdesc) || (is_string($ogdesc) && '' === $ogdesc)) {
            $ogdesc = str_replace('[&hellip;]', '&hellip;', wp_strip_all_tags(get_the_excerpt($post_id)));
        }

        $ogdesc = strip_shortcodes($ogdesc);

        return rawurlencode(trim(apply_filters('wpseo_opengraph_desc', $ogdesc)));
    }

    /**
     * Get the social sites
     *
     * @return array
     */
    public function getSites(): array
    {
        return array_filter($this->get('sites'), function (array $site) {
            return ! empty($site['link']) && ! empty($site['params']);
        });
    }

    /**
     * Get the sharable link
     * TODO: Support custom URL params
     *
     * @param array $site The social site.
     * @return string
     */
    private function getShareLink(array $site): string
    {
        $params = [];
        if (isset($site['params']['url'])) {
            $params[$site['params']['url']] = $this->getUrlEncoded();
        }
        if (isset($site['params']['title'])) {
            $params[$site['params']['title']] = rawurlencode(html_entity_decode($this->getTitle() . ': ' . $this->getUrl()));
        }
        return add_query_arg($params, $site['link']);
    }

    /**
     * Returns the social icon
     *
     * @param array  $site The social site.
     * @param string $label The site label.
     * @return string
     */
    private function renderIcon(array $site, string $label): string
    {
        $html = '';
        if (! empty($site['icon'])) {
            $html .= '<i class="' . esc_attr($site['icon']) . '" aria-hidden="true"></i>';
            if (! empty($site['label'])) {
                $html .= '<span class="' . esc_attr($this->get('screen_reader_class')) . '">' . $label . '</span>';
            }
        }
        return $html;
    }

    /**
     * Returns the social image
     *
     * @param array  $site The social site.
     * @param string $label The site label.
     * @return string
     */
    private function renderImage(array $site, string $label): string
    {
        $html = '';
        if (! empty($site['image'])) {
            $alt = $label ? : pathinfo($site['image'], PATHINFO_FILENAME);
            $html .= '<img src="' . esc_url($site['image']) . '" alt="' . esc_attr($alt) . '" />';
        }
        return $html;
    }

    /**
     * Returns the item link
     *
     * @param array  $site The social site.
     * @param string $key The site key.
     * @return string
     */
    private function renderLink(array $site, string $key): string
    {
        $type = $this->get('type');
        $label = esc_attr(empty($site['label']) ? ucwords($key) : $site['label']);
        $html = '<a href="' . $this->getShareLink($site) . '" target="_blank" title="' . $label . '">';
        if ('icon' === $type) {
            $html .= $this->renderIcon($site, $label);
        } elseif ('image' === $type) {
            $html .= $this->renderImage($site, $label);
        }
        $html .= '</a>';
        return $html;
    }

    /**
     * Returns the item
     *
     * @param array  $site The social site.
     * @param string $key The site key.
     * @return string
     */
    private function renderItem(array $site, string $key): string
    {
        $item = $this->get('item_element');
        $html = '';
        $html .= "<{$item}";

        if (! empty($this->get('item_class'))) {
            $html .= ' class="' . $this->get('item_class') . '"';
        }

        $html .= '>';
        $html .= $this->renderLink($site, $key);
        $html .= "</{$item}>";
        return $html;
    }

    /**
     * Returns the final HTML output
     *
     * @return string
     */
    public function render(): string
    {
        $html = '';
        $container = $this->get('container_element');
        $container_class = $this->get('container_class');

        if (! empty($this->getSites())) {
            $html .= "<{$container}";

            if (! empty($container_class)) {
                $html .= ' class="' . esc_attr($container_class) . '"';
            }

            $html .= '>';

            foreach ($this->getSites() as $key => $site) {
                $html .= $this->renderItem($site, $key);
            }

            $html .= "</{$container}>";
        }

        return $html;
    }
}
