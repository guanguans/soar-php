# 3 Rules Overview

## AddHasOptionsDocCommentRector

Add has options doc comment

- class: [`Guanguans\SoarPHP\Support\Rectors\AddHasOptionsDocCommentRector`](AddHasOptionsDocCommentRector.php)

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

## AddSoarOptionsDocCommentRector

Add soar options doc comment

- class: [`Guanguans\SoarPHP\Support\Rectors\AddSoarOptionsDocCommentRector`](AddSoarOptionsDocCommentRector.php)

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

## SimplifyListIndexRector

Simplify list index

- class: [`Guanguans\SoarPHP\Support\Rectors\SimplifyListIndexRector`](SimplifyListIndexRector.php)

```diff
 [
-    0 => 'delimiter',
-    1 => 'orderbynull',
-    2 => 'groupbyconst',
+    'delimiter',
+    'orderbynull',
+    'groupbyconst',
 ]
```

<br>
