# 2 Rules Overview

## AddDocCommentForHasOptionsRector

Add doc comment for has options rector

- class: [`Guanguans\SoarPHP\Support\Rectors\AddDocCommentForHasOptionsRector`](AddDocCommentForHasOptionsRector.php)

```diff
+/**
+ * @method \Guanguans\SoarPHP\Soar exceptVerbose() // Verbose
+ * @method \Guanguans\SoarPHP\Soar exceptVersion() // Print version info
+ * @method \Guanguans\SoarPHP\Soar exceptHelp() // Help
+ *
+ * @mixin \Guanguans\SoarPHP\Soar
+ */
 trait HasOptions
 {
 }
```

<br>

## AddDocCommentForSoarOptionsRector

Add doc comment for soar options rector

- class: [`Guanguans\SoarPHP\Support\Rectors\AddDocCommentForSoarOptionsRector`](AddDocCommentForSoarOptionsRector.php)

```diff
 return [
+     // AllowCharsets (default "utf8,utf8mb4")
     '-allow-charsets' => [
         0 => 'utf8',
         1 => 'utf8mb4',
     ],
+
+     // AllowCollates
     '-allow-collates' => [
     ],
+
+     // AllowDropIndex, 允许输出删除重复索引的建议
     '-allow-drop-index' => false,
 ];
```

<br>
