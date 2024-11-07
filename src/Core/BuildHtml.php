<?php

namespace Frog\Templating\Core;

use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;

/**
 * Class BuildHTML
 * Generates HTML from a YAML structure.
 */
class BuildHTML
{
    private array $yamlData = [];
    private string $htmlOutput = '';

    /**
     * Loads YAML from file or string and parses it.
     *
     * @param string $yaml Input YAML (file path or string).
     * @param bool $isFile True if input is a file path.
     * @throws \Exception on parse error.
     */
    private function loadYaml(string $yaml, bool $isFile = true): void
    {
        try {
            $this->yamlData = $isFile ? Yaml::parseFile($yaml) : Yaml::parse($yaml);
        } catch (ParseException $e) {
            throw new \Exception("YAML Parsing Error: " . $e->getMessage());
        }
    }

    /**
     * Generates HTML for CDN links or scripts.
     *
     * @param string $type Either 'cdns' or 'scripts'.
     */
    private function generateLinksOrScripts(string $type): void
    {
        foreach ($this->yamlData[$type] ?? [] as $item) {
            if ($type === 'cdns') {
                $ext = pathinfo($item, PATHINFO_EXTENSION);
                $tag = $ext === 'css' ? "<link rel='stylesheet' href='$item'>" : "<script src='$item'></script>";
            } else {
                $tag = isset($item['src']) ? "<script src='{$item['src']}'></script>" : "<script>{$item['inline']}</script>";
            }
            $this->htmlOutput .= "$tag\n";
        }
    }

    /**
     * Recursively generates HTML for content sections.
     *
     * @param array $contentArray Array of content elements.
     * @return string HTML output.
     */
    private function generateContent(array $contentArray): string
    {
        $html = '';
        foreach ($contentArray as $content) {
            $tag = $content['tag'];
            $attributes = $this->buildAttributes($content);
            $html .= "<$tag$attributes>";
            $html .= is_array($content['content'] ?? null) ? $this->generateContent($content['content']) : ($content['content'] ?? '');
            $html .= "</$tag>";
        }
        return $html;
    }

    /**
     * Builds tag attributes from YAML.
     *
     * @param array $attributes Array of attributes.
     * @return string Formatted attributes.
     */
    private function buildAttributes(array $attributes): string
    {
        $attrStr = '';
        foreach ($attributes as $key => $value) {
            if ($key === 'tag' || $key === 'content') continue;
            if (is_array($value)) {
                $value = implode(';', array_map(fn($k, $v) => "$k:$v", array_keys($value), $value));
            }
            $attrStr .= " $key=\"$value\"";
        }
        return $attrStr;
    }

    /**
     * Builds HTML output from YAML configuration.
     *
     * @param string $yaml Input YAML string or file path.
     * @param bool $isFile True if input is a file path.
     * @return string HTML output.
     */
    public function build(string $yaml, bool $isFile = true): string
    {
        $this->loadYaml($yaml, $isFile);
        $this->generateLinksOrScripts('cdns');
        $this->htmlOutput .= $this->generateContent($this->yamlData['sections'] ?? []);
        $this->generateLinksOrScripts('scripts');
        return $this->htmlOutput;
    }
    // is Yaml valide
    public function isYamlValid(string $yaml, bool $isFile = true): bool
    {
        try {
            $this->loadYaml($yaml, $isFile);
            return true;
        } catch (\Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }
}
