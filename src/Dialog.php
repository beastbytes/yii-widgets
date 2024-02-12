<?php
/**
 * @copyright Copyright © 2024 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Yii\Widgets;

use Yiisoft\Html\Html;
use Yiisoft\Html\Tag\Button;
use Yiisoft\Html\Tag\CustomTag;
use Yiisoft\Html\Tag\Div;
use Yiisoft\Html\Tag\Footer;
use Yiisoft\Html\Tag\Header;
use Yiisoft\Html\Tag\Section;
use Yiisoft\Widget\Widget;

final class Dialog extends Widget
{
    public const CLOSE_DIALOG_ATTRIBUTE = 'data-close-dialog';
    public const IS_MODAL_ATTRIBUTE = 'data-is-modal';
    public const IS_NOT_MODAL = 'false';
    public const OPEN_DIALOG_ATTRIBUTE = 'data-open-dialog';

    private const CLOSE_DIALOG_ARIA_LABEL = 'close dialog';
    private const CLOSE_DIALOG_CLASS = 'close-dialog';
    private const DIALOG_CLASS = 'dialog';
    private const DIALOG_BODY_CLASS = 'dialog-body';
    private const DIALOG_FOOTER_CLASS = 'dialog-footer';
    private const DIALOG_HEADER_CLASS = 'dialog-header';
    private const DIALOG_HEADER_CONTENT_CLASS = 'dialog-header-content';
    private const ID_PREFIX = 'dialog-';

    private array $attributes = [];
    private string $body = '';
    private array $buttonAttributes = [];
    private string $buttonLabel = '&times;';
    private string $footer = '';
    private string $header = '';

    public function attributes(array $attributes): self
    {
        $new = clone $this;
        $new->attributes = $attributes;

        return $new;
    }

    /**
     * Returns a new instance with changed dialog body.
     *
     * @param string $value The dialog body.
     */
    public function body(string $value): self
    {
        $new = clone $this;
        $new->body = $value;

        return $new;
    }

    public function buttonAttributes(array $attributes): self
    {
        $new = clone $this;
        $new->buttonAttributes = $attributes;

        return $new;
    }

    /**
     * Returns a new instance with the label for the button.
     *
     * @param string $value The label for the button.
     */
    public function buttonLabel(string $value = ''): self
    {
        $new = clone $this;
        $new->buttonLabel = $value;

        return $new;
    }

    /**
     * Returns a new instance with the footer content.
     *
     * @param string $value The footer content of the dialog.
     */
    public function footer(string $value): self
    {
        $new = clone $this;
        $new->footer = $value;

        return $new;
    }

    /**
     * Returns a new instance with the header content.
     *
     * @param string $value The header content of the dialog.
     */
    public function header(string $value): self
    {
        $new = clone $this;
        $new->header = $value;

        return $new;
    }

    /**
     * Returns a new instance with the specified Widget ID.
     *
     * @param string $value The id of the widget.
     */
    public function id(string $value): self
    {
        $new = clone $this;
        $new->attributes['id'] = $value;

        return $new;
    }

    public function begin(): ?string
    {
        parent::begin();
        ob_start();
        ob_implicit_flush(false);
        return null;
    }

    public function getId(): string
    {
        if (!array_key_exists('id', $this->attributes)) {
            $this->attributes['id'] = Html::generateId(self::ID_PREFIX);
        }

        return $this->attributes['id'];
    }

    public function render(): string
    {
        if (!array_key_exists('id', $this->attributes)) {
            $this->attributes['id'] = Html::generateId(self::ID_PREFIX);
        }

        Html::addCssClass($this->attributes, self::DIALOG_CLASS);

        return CustomTag::name('dialog')
            ->attributes($this->attributes)
            ->content(
                $this->renderHeader()
                . $this->renderBody()
                . $this->renderFooter()
            )
            ->encode(false)
            ->render()
        ;
    }

    private function renderButton(): string
    {
        $buttonAttributes = array_merge(
            $this->buttonAttributes,
            [
                'aria-label' => self::CLOSE_DIALOG_ARIA_LABEL,
                self::CLOSE_DIALOG_ATTRIBUTE => true
            ]
        );

        Html::addCssClass($buttonAttributes, self::CLOSE_DIALOG_CLASS);

        return Button::tag()
            ->attributes($buttonAttributes)
            ->content($this->buttonLabel)
            ->encode(false)
            ->type('reset#')
            ->render()
        ;
    }

    private function renderBody(): string
    {
        return Section::tag()
            ->attributes(['class' => self::DIALOG_BODY_CLASS])
            ->content($this->body === '' ? (string)ob_get_clean() : $this->body)
            ->encode(false)
            ->render()
        ;
    }

    private function renderFooter(): string
    {
        return $this->footer === ''
            ? ''
            : Footer::tag()
                ->attributes(['class' => self::DIALOG_FOOTER_CLASS])
                ->content($this->footer)
                ->encode(false)
                ->render()
        ;
    }

    private function renderHeader(): string
    {
        return Header::tag()
             ->attributes(['class' => self::DIALOG_HEADER_CLASS])
             ->content(
                 $this->renderHeaderContent()
                 . $this->renderButton()
             )
             ->encode(false)
             ->render()
        ;
    }

    private function renderHeaderContent(): string
    {
        return Div::tag()
            ->attributes(['class' => self::DIALOG_HEADER_CONTENT_CLASS])
            ->content($this->header)
            ->encode(false)
            ->render()
        ;
    }
}
