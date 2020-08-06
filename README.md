# WPML Grouped Post in Rest API

This plugin enables a new Route in WordPress API 

`/qubired/v2` 

Under those routes you can find:

```YAML
"/qubired/v2/locales/posts"
"/qubired/v2/locales/posts/(?P\d+)"
"/qubired/v2/locales/pages"
"/qubired/v2/locales/pages/(?P\d+)"
```

## Structure
---

The scope of plugin is to group each **Posts** with a list of available translations:
```YAML
  "en":{
    ID: "xxx",
    post_content: "lorem ipsum",
    ...
    all data from WP_Query..
    ...
    locale: "en",
    locale_slug: "test-title-in-english",
    categories: [
      1, 3, 5, 7
    ],
    tags: [
      {
        term_id: 81,
        name: "tag name",
        slug: "tag-slug",
        term_group: 0,
        term_taxonomy_id: 81,
        taxonomy: "post_tag",
        description: "description of the tag",
        parent: 0,
        count: 1,
        filter: "raw"
      }
    ]
  },
  "it":{},
  "es":{},
  ... all translations available
}
```


## Query Params
---
...coming soon