<script>
        <?php
        if (empty($checkboxes)) {
            ?>
            CKEDITOR.ClassicEditor.create(document.getElementById('editor0'), {
                toolbar: {
                    items: [
                        'undo', 'redo',
                        'alignment', '|',
                        'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', 'highlight', '|',
                        'bold', 'italic', 'underline', 'subscript', 'superscript', '|',
                        'bulletedList', 'numberedList', '|',
                        'outdent', 'indent', '|',
                        'insertTable', '|',
                        'horizontalLine', 'pageBreak', '|',
                    ],
                    shouldNotGroupWhenFull: true
                },
                list: {
                    properties: {
                        styles: true,
                        startIndex: true,
                        reversed: true
                    }
                },
                fontFamily: {
                    options: ['Browallia New'],
                    supportAllValues: true,
                    default: 'Browallia New'
                },
                fontSize: {
                    options: [20],
                    supportAllValues: true,
                    default: '20px'
                },
                link: {
                    decorators: {
                        addTargetToExternalLinks: true,
                        defaultProtocol: 'https://',
                        toggleDownloadable: {
                            mode: 'manual',
                            label: 'Downloadable',
                            attributes: {
                                download: 'file'
                            }
                        }
                    }
                },
                removePlugins: [
                    'AIAssistant',
                    'CKBox',
                    'CKFinder',
                    'EasyImage',
                    'MultiLevelList',
                    'RealTimeCollaborativeComments',
                    'RealTimeCollaborativeTrackChanges',
                    'RealTimeCollaborativeRevisionHistory',
                    'PresenceList',
                    'Comments',
                    'TrackChanges',
                    'TrackChangesData',
                    'RevisionHistory',
                    'Pagination',
                    'WProofreader',
                    'MathType',
                    'SlashCommand',
                    'Template',
                    'DocumentOutline',
                    'FormatPainter',
                    'TableOfContents',
                    'PasteFromOfficeEnhanced',
                    'CaseChange'
                ]
            });
            <?php
        } else {
            foreach ($checkboxes as $index => $checkbox) {
                ?>
                CKEDITOR.ClassicEditor.create(document.getElementById('editor<?php echo $index; ?>'), {
                    toolbar: {
                        items: [
                        'undo', 'redo',
                        'alignment', '|',
                        'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', 'highlight', '|',
                        'bold', 'italic', 'underline', 'subscript', 'superscript', '|',
                        'bulletedList', 'numberedList', '|',
                        'outdent', 'indent', '|',
                        'insertTable', '|',
                        'horizontalLine', 'pageBreak', '|',
                    ],
                        shouldNotGroupWhenFull: true
                    },
                    list: {
                        properties: {
                            styles: true,
                            startIndex: true,
                            reversed: true
                        }
                    },
                    fontFamily: {
                        options: ['Browallia New'],
                        supportAllValues: true,
                        default: 'Browallia New'
                    },
                    fontSize: {
                        options: [20],
                        supportAllValues: true,
                        default: '20px'
                    },
                    link: {
                        decorators: {
                            addTargetToExternalLinks: true,
                            defaultProtocol: 'https://',
                            toggleDownloadable: {
                                mode: 'manual',
                                label: 'Downloadable',
                                attributes: {
                                    download: 'file'
                                }
                            }
                        }
                    },
                    removePlugins: [
                        'AIAssistant',
                        'CKBox',
                        'CKFinder',
                        'EasyImage',
                        'MultiLevelList',
                        'RealTimeCollaborativeComments',
                        'RealTimeCollaborativeTrackChanges',
                        'RealTimeCollaborativeRevisionHistory',
                        'PresenceList',
                        'Comments',
                        'TrackChanges',
                        'TrackChangesData',
                        'RevisionHistory',
                        'Pagination',
                        'WProofreader',
                        'MathType',
                        'SlashCommand',
                        'Template',
                        'DocumentOutline',
                        'FormatPainter',
                        'TableOfContents',
                        'PasteFromOfficeEnhanced',
                        'CaseChange'
                    ]
                });
                <?php
            }
        }
        ?>
    </script>