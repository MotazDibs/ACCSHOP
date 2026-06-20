<main class="container py-4">
  <div class="full-center">
    <div class="row justify-content-center">
      <div class="col-lg-10 col-xl-8">
        <div class="card shadow border-0">
          <div class="card-body p-4">
            <h2 class="mb-4 text-center">✏ تعديل محتوى الملف</h2>

            <?php if ($this->session->flashdata('success')){ ?>
              <div class="alert alert-success text-center mb-4"><?= $this->session->flashdata('success') ?></div>
            <?php } elseif ($this->session->flashdata('error')) { ?>
              <div class="alert alert-danger text-center mb-4"><?= $this->session->flashdata('error') ?></div>
            <?php } ?>

            <?php if (!empty($content) && is_object($content) && isset($content->content_html)) { ?>
              <form method="post" action="<?= base_url('documents/update_file') ?>">
                <input type="hidden" name="filename" value="<?php echo $filename; ?>">

                <div class="mb-3">
                  <label for="editor" class="form-label fw-bold">المحتوى:</label>
                  <textarea name="content_html" id="editor" class="form-control" rows="25" dir="rtl" style="background:#f9f9f9; font-size:1.1rem;"><?php echo $content->content_html; ?></textarea>
                </div>

                <div class="d-flex justify-content-center">
                  <button type="submit" class="btn btn-primary px-5 py-2 fs-5">💾 حفظ التعديلات</button>
                </div>
              </form>
            <?php } else { ?>
              <div class="alert alert-warning text-center">⚠ لا يوجد محتوى متاح.</div>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>

<!-- CKEditor 4 Full -->
<script src="https://cdn.ckeditor.com/4.21.0/full-all/ckeditor.js"></script>
<script>
  if (document.getElementById('editor')) {
    CKEDITOR.replace('editor', {
      contentsLangDirection: 'rtl',
      height: 600,
      allowedContent: true,  // السماح بكل التنسيقات HTML للحفاظ على المحتوى

      toolbar: [
        { name: 'document', items: ['Source', '-', 'NewPage', 'Preview', '-', 'Templates'] },
        { name: 'clipboard', items: ['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo'] },
        { name: 'editing', items: ['Find', 'Replace', '-', 'SelectAll', '-', 'Scayt'] },
        { name: 'forms', items: ['Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField'] },
        '/',
        { name: 'basicstyles', items: ['Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat'] },
        { name: 'paragraph', items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv',
          '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl'] },
        { name: 'links', items: ['Link', 'Unlink', 'Anchor'] },
        { name: 'insert', items: ['Image', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe'] },
        '/',
        { name: 'styles', items: ['Styles', 'Format', 'Font', 'FontSize'] },
        { name: 'colors', items: ['TextColor', 'BGColor'] },
        { name: 'tools', items: ['Maximize', 'ShowBlocks'] },
        { name: 'about', items: ['About'] }
      ],

      contentsCss: [
        'https://cdn.ckeditor.com/4.21.0/full-all/contents.css',
        'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css',
        'body { white-space: pre-wrap; }'
      ],

      // تمكين تكبير المحرر تلقائياً حسب المحتوى
      autoGrow_minHeight: 200,
      autoGrow_maxHeight: 300,
      autoGrow_bottomSpace: 50,
      extraPlugins: 'autogrow,justify,font,colorbutton,clipboard,dialog,dialogui,elementspath,scayt,tableresize,tabletools',
      removePlugins: 'resize'  // لان AutoGrow يتطلب إزالة resize الافتراضي
    });
  }
</script>
