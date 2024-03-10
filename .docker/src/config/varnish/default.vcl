acl purge {
    "localhost";
    "127.0.0.1";
}

sub vcl_backend_response {
    # Don't cache 50x responses
    if (
        beresp.status == 500 ||
        beresp.status == 502 ||
        beresp.status == 503 ||
        beresp.status == 504
    ) {
        return (pass);
    }

    # === DO NOT CACHE ===
    # Exclude the following paths (e.g. backend admins, user pages or ad URLs that require tracking)
    # In Joomla specifically, you are advised to create specific entry points (URLs) for users to
    # interact with the site (either common user logins or even commenting), e.g. make a menu item
    # to point to a user login page (e.g. /login), including all related functionality such as
    # password reset, email reminder and so on.
    if (
        bereq.url ~ "^/addons" ||
        bereq.url ~ "^/cart" ||
        bereq.url ~ "^/panier" ||
        bereq.url ~ "^/checkout" ||
        bereq.url ~ "^/commander" ||
        bereq.url ~ "^/lost-password" ||
        bereq.url ~ "^/my-account" ||
        bereq.url ~ "^/mon-compte" ||
        bereq.url ~ "^/wc-api" ||
        bereq.url ~ "^/wp-admin" ||
        bereq.url ~ "^/wp-login.php" ||
        bereq.url ~ "^\?add-to-cart=" ||
        bereq.url ~ "^\?wc-api="
    ) {
        #set beresp.http.Cache-Control = "private, max-age=0, no-cache, no-store";
        #set beresp.http.Expires = "Mon, 01 Jan 2001 00:00:00 GMT";
        #set beresp.http.Pragma = "no-cache";
        set beresp.uncacheable = true;
        return (deliver);
    }

    # Don't cache HTTP authorization/authentication pages and pages with certain headers or cookies
    if (
        bereq.http.Authorization ||
        bereq.http.Authenticate ||
        bereq.http.X-Logged-In == "True" ||
        bereq.http.Cookie ~ "userID" ||
        bereq.http.Cookie ~ "joomla_[a-zA-Z0-9_]+" ||
        bereq.http.Cookie ~ "(wordpress_[a-zA-Z0-9_]+|wp-postpass|comment_author_[a-zA-Z0-9_]+|woocommerce_cart_hash|woocommerce_items_in_cart|wp_woocommerce_session_[a-zA-Z0-9]+)"
    ) {
        #set beresp.http.Cache-Control = "private, max-age=0, no-cache, no-store";
        #set beresp.http.Expires = "Mon, 01 Jan 2001 00:00:00 GMT";
        #set beresp.http.Pragma = "no-cache";
        set beresp.uncacheable = true;
        return (deliver);
    }

    # Don't cache ajax requests
    if (beresp.http.X-Requested-With == "XMLHttpRequest" || bereq.url ~ "nocache") {
        #set beresp.http.Cache-Control = "private, max-age=0, no-cache, no-store";
        #set beresp.http.Expires = "Mon, 01 Jan 2001 00:00:00 GMT";
        #set beresp.http.Pragma = "no-cache";
        set beresp.uncacheable = true;
        return (deliver);
    }

    # Don't cache backend response to posted requests
    if (bereq.method == "POST") {
        set beresp.uncacheable = true;
        return (deliver);
    }

    # Ok, we're cool & ready to cache things
    # so let's clean up some headers and cookies
    # to maximize caching.

    # Check for the custom "X-Logged-In" header to identify if the visitor is a guest,
    # then unset any cookie (including session cookies) provided it's not a POST request.
    if (beresp.http.X-Logged-In == "False" && bereq.method != "POST") {
        unset beresp.http.Set-Cookie;
    }

    # Unset the "pragma" header (suggested)
    unset beresp.http.Pragma;

    # Unset the "vary" header (suggested)
    unset beresp.http.Vary;

    # Unset the "etag" header (optional)
    #unset beresp.http.etag;

    # Allow stale content, in case the backend goes down
    set beresp.grace = 24h;

    # Enforce your own cache TTL (optional)
    #set beresp.ttl = 180s;

    # Modify "expires" header (optional)
    #set beresp.http.Expires = "" + (now + beresp.ttl);

    # If your backend server does not set the right caching headers for static assets,
    # you can set them below (uncomment first and change 604800 - which 1 week - to whatever you
    # want (in seconds)
    #if (bereq.url ~ "\.(ico|jpg|jpeg|gif|png|bmp|webp|tiff|svg|svgz|pdf|mp3|flac|ogg|mid|midi|wav|mp4|webm|mkv|ogv|wmv|eot|otf|woff|ttf|rss|atom|zip|7z|tgz|gz|rar|bz2|tar|exe|doc|docx|xls|xlsx|ppt|pptx|rtf|odt|ods|odp)(\?[a-zA-Z0-9=]+)$") {
    #    set beresp.http.Cache-Control = "public, max-age=604800";
    #}

    if (bereq.url ~ "^[^?]*\.(7z|avi|bmp|bz2|css|csv|doc|docx|eot|flac|flv|gif|gz|ico|jpeg|jpg|js|less|mka|mkv|mov|mp3|mp4|mpeg|mpg|odt|ogg|ogm|opus|otf|pdf|png|ppt|pptx|rar|rtf|svg|svgz|swf|tar|tbz|tgz|ttf|txt|txz|wav|webm|webp|woff|woff2|xls|xlsx|xml|xz|zip)(\?.*)?$") {
        unset beresp.http.set-cookie;
        set beresp.do_stream = true;
    }

    # We have content to cache, but it's got no-cache or other Cache-Control values sent
    # So let's reset it to our main caching time (180s as used in this example configuration)
    # The additional parameters specified (stale-while-revalidate & stale-if-error) are used
    # by modern browsers to better control caching. Set these to twice & four times your main
    # cache time respectively.
    # This final setting will normalize cache-control headers for CMSs like Joomla
    # which set max-age=0 even when the CMS' cache is enabled.
    if (beresp.http.Cache-Control !~ "max-age" || beresp.http.Cache-Control ~ "max-age=0") {
        set beresp.http.Cache-Control = "public, max-age=180, stale-while-revalidate=360, stale-if-error=43200";
    }

    # Optionally set a larger TTL for pages with less than 180s of cache TTL
    #if (beresp.ttl < 180s) {
    #    set beresp.http.Cache-Control = "public, max-age=180, stale-while-revalidate=360, stale-if-error=43200";
    #}

    return (deliver);
}

sub vcl_recv {
  if (req.method == "PURGE") {
    if (!client.ip ~ purge) {
      return (synth(405, "Not allowed."));
    }
    return (hash);
  }

  if (req.url ~ "\.(gif|jpg|jpeg|swf|css|js|flv|mp3|mp4|pdf|ico|png)(\?.*|)$") {
    unset req.http.cookie;
    set req.url = regsub(req.url, "\?.*$", "");
  }

  if (req.url ~ "\?(utm_(campaign|medium|source|term)|adParams|client|cx|eid|fbid|feed|ref(id|src)?|v(er|iew))=") {
    set req.url = regsub(req.url, "\?.*$", "");
  }

  # Fix Wordpress visual editor issues, must be the first one to work
  if (req.url ~ "/wp-(login|admin|comments-post.php|cron)" || req.url ~ "preview=true" || req.url ~ "xmlrpc.php") {
    return (pass);
  }

  # Do not cache AJAX requests.
  if (req.http.X-Requested-With == "XMLHttpRequest") {
      return(pass);
  }

  # Post requests will not be cached
  if (req.http.Authorization || req.method == "POST") {
    return (pass);
  }

  # Dont Cache WordPress post pages and edit pages
  if (req.url ~ "(wp-admin|post\.php|edit\.php|wp-login)") {
    return(pass);
  }
  if (req.url ~ "/wp-cron.php" || req.url ~ "preview=true") {
    return (pass);
  }

  # Woocommerce
  if (
       req.url ~ "^/addons" ||
       req.url ~ "^/cart" ||
       req.url ~ "^/panier" ||
       req.url ~ "^/checkout" ||
       req.url ~ "^/commander" ||
       req.url ~ "^/lost-password" ||
       req.url ~ "^/my-account" ||
       req.url ~ "^/mon-compte" ||
       req.url ~ "^/wc-api" ||
       req.url ~ "^/wp-admin" ||
       req.url ~ "^/wp-login.php" ||
       req.url ~ "^\?add-to-cart=" ||
       req.url ~ "^\?wc-api="
   ) {
    return (pass);
  }

  # Pass through the WooCommerce API
  if (req.url ~ "\?wc-api=" ) {
    return (pass);
  }

  # Pass through the WooCommerce add to cart
  if (req.url ~ "\?add-to-cart=" ) {
    return (pass);
  }

  if (req.url ~ "\?wc-ajax=" ) {
    return (pass);
  }

  if (req.url ~ "\?cart=" ) {
    return (pass);
  }

  if (req.http.cookie) {
    if (req.http.cookie ~ "(wordpress_|wp-settings-)" || req.http.cookie ~ "woocommerce_(cart|session)|wp_woocommerce_session") {
      return(pass);
    } else {
      unset req.http.cookie;
    }
  }
}

# Needed for SSL support
sub vcl_hash {
   if ( req.http.X-Forwarded-Proto ) {
    hash_data( req.http.X-Forwarded-Proto );
   }
}

sub vcl_deliver {
  # multi-server webfarm? set a variable here so you can check
  # the headers to see which frontend served the request
  #   set resp.http.X-Server = "server-01";
   if (obj.hits > 0) {
     set resp.http.X-Cache = "HIT";
   } else {
     set resp.http.X-Cache = "MISS";
   }
}

sub vcl_hit {
  if (req.method == "PURGE") {
    return (synth(200, "OK"));
  }
}

sub vcl_miss {
  if (req.method == "PURGE") {
    return (synth(404, "Not cached"));
  }
}
