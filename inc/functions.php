<?php

function hasLink(int $postId, string $linkId): string
{
    $links = get_post_meta($postId, '_link', true);

    return isset($links[$linkId]);
}

function getLink(int $postId, string $linkId): string
{
    $links = get_post_meta($postId, '_link', true);

    return isset($links[$linkId]) ? $links[$linkId] : '';
}

function theLink(string $before = '', string $after = ''): void
{
    echo $before.getLink(get_the_ID()).$after;
}
