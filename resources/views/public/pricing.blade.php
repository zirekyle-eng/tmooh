@php

/**
 * كل مرحلة تحتوي على:
 *  - subjects: المواد الفردية [name, session (سعر الحصة), monthly (دفع شهري), quarterly (دفع فصلي)]
 *  - bundles : الباقات (مجموعات مواد) [name, quarterly (الدفع الفصلي), discounted (بعد التخفيض)]
 */
$regions = [
  'gaza' => [
    'title' => 'غزة والضفة',
    'subtitle' => 'أسعار حسب المرحلة الدراسية، بالحصة الفردية أو بالباقة الموفّرة.',
    'currency' => '₪',
    'stages' => [
      [
        'name' => 'المرحلة الإعدادية',
        'subjects' => [
          ['name' => 'رياضيات', 'session' => 4, 'monthly' => 48, 'quarterly' => 144],
          ['name' => 'علوم', 'session' => 4, 'monthly' => 48, 'quarterly' => 144],
          ['name' => 'انجليزي', 'session' => 4, 'monthly' => 48, 'quarterly' => 144],
          ['name' => 'لغة عربية', 'session' => 4, 'monthly' => 32, 'quarterly' => 96],
          ['name' => 'دين', 'session' => 4, 'monthly' => 32, 'quarterly' => 96],
          ['name' => 'تكنولوجيا', 'session' => 4, 'monthly' => 32, 'quarterly' => 96],
        ],
        'bundles' => [
          ['name' => 'رياضيات + علوم + انجلش', 'quarterly' => 432, 'discounted' => 430],
          ['name' => 'رياضيات + علوم', 'quarterly' => 288, 'discounted' => 280],
          ['name' => 'رياضيات + علوم + انجلش + عربي', 'quarterly' => 528, 'discounted' => 520],
        ],
      ],
      [
        'name' => 'الصف العاشر',
        'subjects' => [
          ['name' => 'رياضيات', 'session' => 5, 'monthly' => 60, 'quarterly' => 180],
          ['name' => 'علوم', 'session' => 5, 'monthly' => 60, 'quarterly' => 180],
          ['name' => 'انجليزي', 'session' => 5, 'monthly' => 60, 'quarterly' => 180],
          ['name' => 'لغة عربية', 'session' => 4, 'monthly' => 32, 'quarterly' => 96],
          ['name' => 'دين', 'session' => 4, 'monthly' => 32, 'quarterly' => 96],
          ['name' => 'تكنولوجيا', 'session' => 4, 'monthly' => 32, 'quarterly' => 96],
        ],
        'bundles' => [
          ['name' => 'رياضيات + علوم', 'quarterly' => 360, 'discounted' => 350],
          ['name' => 'رياضيات + علوم + انجلش + عربي', 'quarterly' => 636, 'discounted' => 630],
          ['name' => 'رياضيات + علوم + انجلش', 'quarterly' => 540, 'discounted' => 530],
        ],
      ],
      [
        'name' => 'الحادي عشر (العلمي)',
        'subjects' => [
          ['name' => 'رياضيات', 'session' => 6, 'monthly' => 72, 'quarterly' => 216],
          ['name' => 'كيمياء', 'session' => 6, 'monthly' => 72, 'quarterly' => 216],
          ['name' => 'فيزياء', 'session' => 6, 'monthly' => 72, 'quarterly' => 216],
          ['name' => 'أحياء', 'session' => 6, 'monthly' => 72, 'quarterly' => 216],
          ['name' => 'انجلش', 'session' => 6, 'monthly' => 72, 'quarterly' => 216],
          ['name' => 'عربي', 'session' => 5, 'monthly' => 40, 'quarterly' => 120],
        ],
        'bundles' => [
          ['name' => 'رياضيات + كيمياء + فيزياء + أحياء', 'quarterly' => 864, 'discounted' => 860],
          ['name' => 'رياضيات + انجلش', 'quarterly' => 432, 'discounted' => 430],
          ['name' => 'انجلش + عربي', 'quarterly' => 336, 'discounted' => 330],
          ['name' => 'كيمياء + فيزياء + أحياء', 'quarterly' => 648, 'discounted' => 640],
        ],
      ],
      [
        'name' => 'الحادي عشر (الأدبي)',
        'subjects' => [
          ['name' => 'رياضيات', 'session' => 6, 'monthly' => 72, 'quarterly' => 216],
          ['name' => 'تاريخ', 'session' => 6, 'monthly' => 72, 'quarterly' => 216],
          ['name' => 'جغرافيا', 'session' => 6, 'monthly' => 72, 'quarterly' => 216],
          ['name' => 'انجلش', 'session' => 6, 'monthly' => 72, 'quarterly' => 216],
          ['name' => 'عربي', 'session' => 5, 'monthly' => 40, 'quarterly' => 120],
          ['name' => 'ثقافة علمية', 'session' => 6, 'monthly' => 72, 'quarterly' => 216],
        ],
        'bundles' => [
          ['name' => 'رياضيات + تاريخ + جغرافيا', 'quarterly' => 648, 'discounted' => 640],
          ['name' => 'عربي + انجلش', 'quarterly' => 336, 'discounted' => 330],
          ['name' => 'تاريخ + جغرافيا + ثقافة', 'quarterly' => 648, 'discounted' => 640],
        ],
      ],
      [
        'name' => 'الثانوية العامة (علمي)',
        'subjects' => [
          ['name' => 'رياضيات', 'session' => 7, 'monthly' => 84, 'quarterly' => 252],
          ['name' => 'كيمياء', 'session' => 7, 'monthly' => 84, 'quarterly' => 252],
          ['name' => 'فيزياء', 'session' => 7, 'monthly' => 84, 'quarterly' => 252],
          ['name' => 'أحياء', 'session' => 7, 'monthly' => 84, 'quarterly' => 252],
          ['name' => 'انجلش', 'session' => 7, 'monthly' => 84, 'quarterly' => 252],
          ['name' => 'عربي', 'session' => 6, 'monthly' => 48, 'quarterly' => 144],
        ],
        'bundles' => [
          ['name' => 'رياضيات + كيمياء + فيزياء + أحياء', 'quarterly' => 1008, 'discounted' => 1000],
          ['name' => 'رياضيات + انجلش', 'quarterly' => 504, 'discounted' => 500],
          ['name' => 'انجلش + عربي', 'quarterly' => 396, 'discounted' => 390],
          ['name' => 'كيمياء + فيزياء + أحياء', 'quarterly' => 756, 'discounted' => 750],
        ],
      ],
      [
        'name' => 'الثانوية العامة (أدبي)',
        'subjects' => [
          ['name' => 'رياضيات', 'session' => 7, 'monthly' => 84, 'quarterly' => 252],
          ['name' => 'تاريخ', 'session' => 7, 'monthly' => 84, 'quarterly' => 252],
          ['name' => 'جغرافيا', 'session' => 7, 'monthly' => 84, 'quarterly' => 252],
          ['name' => 'انجلش', 'session' => 7, 'monthly' => 84, 'quarterly' => 252],
          ['name' => 'عربي', 'session' => 6, 'monthly' => 48, 'quarterly' => 144],
          ['name' => 'ثقافة علمية', 'session' => 6, 'monthly' => 72, 'quarterly' => 216],
        ],
        'bundles' => [
          ['name' => 'رياضيات + تاريخ + جغرافيا', 'quarterly' => 756, 'discounted' => 750],
          ['name' => 'عربي + انجلش', 'quarterly' => 396, 'discounted' => 390],
          ['name' => 'تاريخ + جغرافيا + ثقافة', 'quarterly' => 720, 'discounted' => 700],
        ],
      ],
    ],
  ],
  'egypt' => [
    'title' => 'مصر',
    'subtitle' => 'أسعار مناسبة للطلاب المقيمين في مصر، بالحصة الفردية أو بالباقة الموفّرة.',
    'currency' => 'ج.م',
    'stages' => [
      [
        'name' => 'المرحلة الإعدادية',
        'subjects' => [
          ['name' => 'رياضيات', 'session' => 80, 'monthly' => 960, 'quarterly' => 2880],
          ['name' => 'علوم', 'session' => 80, 'monthly' => 960, 'quarterly' => 2880],
          ['name' => 'انجليزي', 'session' => 80, 'monthly' => 960, 'quarterly' => 2880],
          ['name' => 'لغة عربية', 'session' => 70, 'monthly' => 560, 'quarterly' => 1680],
          ['name' => 'دين', 'session' => 70, 'monthly' => 560, 'quarterly' => 1680],
          ['name' => 'تكنولوجيا', 'session' => 70, 'monthly' => 560, 'quarterly' => 1680],
        ],
        'bundles' => [
          ['name' => 'رياضيات + علوم + انجلش', 'quarterly' => 8640, 'discounted' => 8000],
          ['name' => 'رياضيات + علوم', 'quarterly' => 5760, 'discounted' => 5500],
          ['name' => 'رياضيات + علوم + انجلش + عربي', 'quarterly' => 10320, 'discounted' => 10000],
        ],
      ],
      [
        'name' => 'الصف العاشر',
        'subjects' => [
          ['name' => 'رياضيات', 'session' => 90, 'monthly' => 1080, 'quarterly' => 3240],
          ['name' => 'علوم', 'session' => 90, 'monthly' => 1080, 'quarterly' => 3240],
          ['name' => 'انجليزي', 'session' => 90, 'monthly' => 1080, 'quarterly' => 3240],
          ['name' => 'لغة عربية', 'session' => 80, 'monthly' => 640, 'quarterly' => 1920],
          ['name' => 'دين', 'session' => 80, 'monthly' => 640, 'quarterly' => 1920],
          ['name' => 'تكنولوجيا', 'session' => 80, 'monthly' => 640, 'quarterly' => 1920],
        ],
        'bundles' => [
          ['name' => 'رياضيات + علوم', 'quarterly' => 6480, 'discounted' => 6000],
          ['name' => 'رياضيات + علوم + انجلش + عربي', 'quarterly' => 11640, 'discounted' => 11500],
          ['name' => 'رياضيات + علوم + انجلش', 'quarterly' => 9720, 'discounted' => 9500],
        ],
      ],
      [
        'name' => 'الحادي عشر (العلمي)',
        'subjects' => [
          ['name' => 'رياضيات', 'session' => 100, 'monthly' => 1200, 'quarterly' => 3600],
          ['name' => 'كيمياء', 'session' => 100, 'monthly' => 1200, 'quarterly' => 3600],
          ['name' => 'فيزياء', 'session' => 100, 'monthly' => 1200, 'quarterly' => 3600],
          ['name' => 'أحياء', 'session' => 100, 'monthly' => 1200, 'quarterly' => 3600],
          ['name' => 'انجلش', 'session' => 100, 'monthly' => 1200, 'quarterly' => 3600],
          ['name' => 'عربي', 'session' => 90, 'monthly' => 720, 'quarterly' => 2160],
        ],
        'bundles' => [
          ['name' => 'رياضيات + كيمياء + فيزياء + أحياء', 'quarterly' => 14400, 'discounted' => 14000],
          ['name' => 'رياضيات + انجلش', 'quarterly' => 7200, 'discounted' => 7000],
          ['name' => 'انجلش + عربي', 'quarterly' => 5760, 'discounted' => 5500],
          ['name' => 'كيمياء + فيزياء + أحياء', 'quarterly' => 10800, 'discounted' => 10500],
        ],
      ],
      [
        'name' => 'الحادي عشر (الأدبي)',
        'subjects' => [
          ['name' => 'رياضيات', 'session' => 100, 'monthly' => 1200, 'quarterly' => 3600],
          ['name' => 'تاريخ', 'session' => 100, 'monthly' => 1200, 'quarterly' => 3600],
          ['name' => 'جغرافيا', 'session' => 100, 'monthly' => 1200, 'quarterly' => 3600],
          ['name' => 'انجلش', 'session' => 100, 'monthly' => 1200, 'quarterly' => 3600],
          ['name' => 'عربي', 'session' => 90, 'monthly' => 720, 'quarterly' => 2160],
          ['name' => 'ثقافة علمية', 'session' => 100, 'monthly' => 1200, 'quarterly' => 3600],
        ],
        'bundles' => [
          ['name' => 'رياضيات + تاريخ + جغرافيا', 'quarterly' => 10800, 'discounted' => 10500],
          ['name' => 'عربي + انجلش', 'quarterly' => 5760, 'discounted' => 5500],
          ['name' => 'تاريخ + جغرافيا + ثقافة', 'quarterly' => 10800, 'discounted' => 10500],
        ],
      ],
      [
        'name' => 'الثانوية العامة (علمي)',
        'subjects' => [
          ['name' => 'رياضيات', 'session' => 110, 'monthly' => 1320, 'quarterly' => 3960],
          ['name' => 'كيمياء', 'session' => 110, 'monthly' => 1320, 'quarterly' => 3960],
          ['name' => 'فيزياء', 'session' => 110, 'monthly' => 1320, 'quarterly' => 3960],
          ['name' => 'أحياء', 'session' => 110, 'monthly' => 1320, 'quarterly' => 3960],
          ['name' => 'انجلش', 'session' => 110, 'monthly' => 1320, 'quarterly' => 3960],
          ['name' => 'عربي', 'session' => 100, 'monthly' => 800, 'quarterly' => 2400],
        ],
        'bundles' => [
          ['name' => 'رياضيات + كيمياء + فيزياء + أحياء', 'quarterly' => 15840, 'discounted' => 15500],
          ['name' => 'رياضيات + انجلش', 'quarterly' => 7920, 'discounted' => 7500],
          ['name' => 'انجلش + عربي', 'quarterly' => 6360, 'discounted' => 6000],
          ['name' => 'كيمياء + فيزياء + أحياء', 'quarterly' => 11880, 'discounted' => 11500],
        ],
      ],
      [
        'name' => 'الثانوية العامة (أدبي)',
        'subjects' => [
          ['name' => 'رياضيات', 'session' => 110, 'monthly' => 1320, 'quarterly' => 3960],
          ['name' => 'تاريخ', 'session' => 110, 'monthly' => 1320, 'quarterly' => 3960],
          ['name' => 'جغرافيا', 'session' => 110, 'monthly' => 1320, 'quarterly' => 3960],
          ['name' => 'انجلش', 'session' => 110, 'monthly' => 1320, 'quarterly' => 3960],
          ['name' => 'عربي', 'session' => 100, 'monthly' => 800, 'quarterly' => 2400],
          ['name' => 'ثقافة علمية', 'session' => 110, 'monthly' => 1320, 'quarterly' => 3960],
        ],
        'bundles' => [
          ['name' => 'رياضيات + تاريخ + جغرافيا', 'quarterly' => 11880, 'discounted' => 11500],
          ['name' => 'عربي + انجلش', 'quarterly' => 6360, 'discounted' => 6000],
          ['name' => 'تاريخ + جغرافيا + ثقافة', 'quarterly' => 11880, 'discounted' => 11500],
        ],
      ],
    ],
  ],
  'world' => [
    'title' => 'باقي الدول',
    'subtitle' => 'أسعار تنافسية للطلاب خارج الوطن، بالحصة الفردية أو بالباقة الموفّرة.',
    'currency' => '$',
    'stages' => [
      [
        'name' => 'المرحلة الإعدادية',
        'subjects' => [
          ['name' => 'رياضيات', 'session' => 1.5, 'monthly' => 18, 'quarterly' => 54],
          ['name' => 'علوم', 'session' => 1.5, 'monthly' => 18, 'quarterly' => 54],
          ['name' => 'انجليزي', 'session' => 1.5, 'monthly' => 18, 'quarterly' => 54],
          ['name' => 'لغة عربية', 'session' => 1.3, 'monthly' => 10.4, 'quarterly' => 31.2],
          ['name' => 'دين', 'session' => 1.3, 'monthly' => 10.4, 'quarterly' => 31.2],
          ['name' => 'تكنولوجيا', 'session' => 1.3, 'monthly' => 10.4, 'quarterly' => 31.2],
        ],
        'bundles' => [
          ['name' => 'رياضيات + علوم + انجلش', 'quarterly' => 162, 'discounted' => 160],
          ['name' => 'رياضيات + علوم', 'quarterly' => 108, 'discounted' => 100],
          ['name' => 'رياضيات + علوم + انجلش + عربي', 'quarterly' => 193.2, 'discounted' => 190],
        ],
      ],
      [
        'name' => 'الصف العاشر',
        'subjects' => [
          ['name' => 'رياضيات', 'session' => 1.6, 'monthly' => 19.2, 'quarterly' => 57.6],
          ['name' => 'علوم', 'session' => 1.6, 'monthly' => 19.2, 'quarterly' => 57.6],
          ['name' => 'انجليزي', 'session' => 1.6, 'monthly' => 19.2, 'quarterly' => 57.6],
          ['name' => 'لغة عربية', 'session' => 1.5, 'monthly' => 12, 'quarterly' => 36],
          ['name' => 'دين', 'session' => 1.5, 'monthly' => 12, 'quarterly' => 36],
          ['name' => 'تكنولوجيا', 'session' => 1.5, 'monthly' => 12, 'quarterly' => 36],
        ],
        'bundles' => [
          ['name' => 'رياضيات + علوم', 'quarterly' => 115.2, 'discounted' => 115],
          ['name' => 'رياضيات + علوم + انجلش + عربي', 'quarterly' => 208.8, 'discounted' => 200],
          ['name' => 'رياضيات + علوم + انجلش', 'quarterly' => 172.8, 'discounted' => 170],
        ],
      ],
      [
        'name' => 'الحادي عشر (العلمي)',
        'subjects' => [
          ['name' => 'رياضيات', 'session' => 2, 'monthly' => 24, 'quarterly' => 72],
          ['name' => 'كيمياء', 'session' => 2, 'monthly' => 24, 'quarterly' => 72],
          ['name' => 'فيزياء', 'session' => 2, 'monthly' => 24, 'quarterly' => 72],
          ['name' => 'أحياء', 'session' => 2, 'monthly' => 24, 'quarterly' => 72],
          ['name' => 'انجلش', 'session' => 2, 'monthly' => 24, 'quarterly' => 72],
          ['name' => 'عربي', 'session' => 1.8, 'monthly' => 14.4, 'quarterly' => 43.2],
        ],
        'bundles' => [
          ['name' => 'رياضيات + كيمياء + فيزياء + أحياء', 'quarterly' => 288, 'discounted' => 280],
          ['name' => 'رياضيات + انجلش', 'quarterly' => 144, 'discounted' => 140],
          ['name' => 'انجلش + عربي', 'quarterly' => 115.2, 'discounted' => 115],
          ['name' => 'كيمياء + فيزياء + أحياء', 'quarterly' => 216, 'discounted' => 215],
        ],
      ],
      [
        'name' => 'الحادي عشر (الأدبي)',
        'subjects' => [
          ['name' => 'رياضيات', 'session' => 2, 'monthly' => 24, 'quarterly' => 72],
          ['name' => 'تاريخ', 'session' => 2, 'monthly' => 24, 'quarterly' => 72],
          ['name' => 'جغرافيا', 'session' => 2, 'monthly' => 24, 'quarterly' => 72],
          ['name' => 'انجلش', 'session' => 2, 'monthly' => 24, 'quarterly' => 72],
          ['name' => 'عربي', 'session' => 1.8, 'monthly' => 14.4, 'quarterly' => 43.2],
          ['name' => 'ثقافة علمية', 'session' => 2, 'monthly' => 24, 'quarterly' => 72],
        ],
        'bundles' => [
          ['name' => 'رياضيات + تاريخ + جغرافيا', 'quarterly' => 216, 'discounted' => 215],
          ['name' => 'عربي + انجلش', 'quarterly' => 115.2, 'discounted' => 115],
          ['name' => 'تاريخ + جغرافيا + ثقافة', 'quarterly' => 216, 'discounted' => 215],
        ],
      ],
      [
        'name' => 'الثانوية العامة (علمي)',
        'subjects' => [
          ['name' => 'رياضيات', 'session' => 2.1, 'monthly' => 25.2, 'quarterly' => 75.6],
          ['name' => 'كيمياء', 'session' => 2.1, 'monthly' => 25.2, 'quarterly' => 75.6],
          ['name' => 'فيزياء', 'session' => 2.1, 'monthly' => 25.2, 'quarterly' => 75.6],
          ['name' => 'أحياء', 'session' => 2.1, 'monthly' => 25.2, 'quarterly' => 75.6],
          ['name' => 'انجلش', 'session' => 2.1, 'monthly' => 25.2, 'quarterly' => 75.6],
          ['name' => 'عربي', 'session' => 2, 'monthly' => 16, 'quarterly' => 48],
        ],
        'bundles' => [
          ['name' => 'رياضيات + كيمياء + فيزياء + أحياء', 'quarterly' => 302.4, 'discounted' => 300],
          ['name' => 'رياضيات + انجلش', 'quarterly' => 151.2, 'discounted' => 150],
          ['name' => 'انجلش + عربي', 'quarterly' => 123.6, 'discounted' => 120],
          ['name' => 'كيمياء + فيزياء + أحياء', 'quarterly' => 226.8, 'discounted' => 225],
        ],
      ],
      [
        'name' => 'الثانوية العامة (أدبي)',
        'subjects' => [
          ['name' => 'رياضيات', 'session' => 2.1, 'monthly' => 25.2, 'quarterly' => 75.6],
          ['name' => 'تاريخ', 'session' => 2.1, 'monthly' => 25.2, 'quarterly' => 75.6],
          ['name' => 'جغرافيا', 'session' => 2.1, 'monthly' => 25.2, 'quarterly' => 75.6],
          ['name' => 'انجلش', 'session' => 2.1, 'monthly' => 25.2, 'quarterly' => 75.6],
          ['name' => 'عربي', 'session' => 2, 'monthly' => 16, 'quarterly' => 48],
          ['name' => 'ثقافة علمية', 'session' => 2.1, 'monthly' => 25.2, 'quarterly' => 75.6],
        ],
        'bundles' => [
          ['name' => 'رياضيات + تاريخ + جغرافيا', 'quarterly' => 226.8, 'discounted' => 225],
          ['name' => 'عربي + انجلش', 'quarterly' => 123.6, 'discounted' => 120],
          ['name' => 'تاريخ + جغرافيا + ثقافة', 'quarterly' => 226.8, 'discounted' => 225],
        ],
      ],
    ],
  ],
];

/** تنسيق الأرقام: يشيل الأصفار الزايدة بعد الفاصلة (مثال: 31.200000000000003 => 31.2) */
function fmt($n) {
  $n = round((float) $n, 2);
  if ($n == (int) $n) return (string) (int) $n;
  return rtrim(rtrim(number_format($n, 2, '.', ''), '0'), '.');
}
@endphp
<!doctype html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>الباقات والأسعار | مدرسة طموح الإلكترونية</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Baloo+Bhaijaan+2:wght@500;600;700;800&family=Tajawal:wght@400;500;700;800&display=swap" rel="stylesheet">
  <style>
    :root{--plum:#2e1a47;--plum2:#51337b;--coral:#ff6b4a;--gold:#ffc857;--mint:#1e9b65;--ink:#241432;--muted:#756882;--line:#eee3f0;--paper:#fffdfa}
    *{box-sizing:border-box}body{margin:0;background:linear-gradient(180deg,#fff9f4 0,#fffdfa 440px);color:var(--ink);font-family:Tajawal,Arial,sans-serif}
    .wrap{max-width:1400px;margin:auto;padding:0 22px}
    .hero{padding:64px 0 104px;background:radial-gradient(circle at 12% 20%,#ffc85755 0 2px,transparent 3px),radial-gradient(circle at 84% 28%,#ffffff2b 0 100px,transparent 101px),linear-gradient(126deg,#211235,#55357e);color:#fff;text-align:center}
    .eyebrow{display:inline-block;border:1px solid #ffffff38;background:#ffffff14;border-radius:99px;padding:6px 13px;color:#ffe2a1;font-size:12px;font-weight:800}
    .hero h1{font:800 43px 'Baloo Bhaijaan 2';margin:12px 0 5px}
    .hero p{max-width:760px;margin:auto;color:#dfd2ec;font-size:15px;line-height:2}
    .region-tabs{max-width:900px;margin:-34px auto 0;position:relative;z-index:2;display:grid;grid-template-columns:repeat(3,1fr);gap:10px;padding:11px;background:#fff;border:1px solid var(--line);border-radius:22px;box-shadow:0 18px 42px #2e1a4720}
    .region-tabs button{appearance:none;border:0;border-radius:14px;background:#fff;color:var(--ink);padding:14px 10px;font:800 15px Tajawal;cursor:pointer;transition:.2s}
    .region-tabs button:hover{background:#fff4f0;transform:translateY(-1px)}
    .region-tabs button.active{background:linear-gradient(135deg,var(--plum),var(--plum2));color:#fff;box-shadow:0 12px 26px rgba(46,26,71,.32)}
    .pricing{padding:45px 0 80px}
    .region-heading{text-align:center;margin:0 0 35px}
    .region-heading h2{font:800 30px 'Baloo Bhaijaan 2';margin:0;color:var(--plum)}
    .region-heading p{margin:7px 0 0;color:var(--muted);font-size:13px}
    .region{display:none}
    .region.active{display:block}
    .stage-section{margin-bottom:42px;background:linear-gradient(180deg,#fff 0%,#fffdfd 100%);border:1.5px solid var(--line);border-radius:26px;padding:22px 22px 18px;box-shadow:0 18px 40px rgba(46,26,71,.06)}
    .stage-title{display:flex;align-items:center;gap:12px;margin-bottom:20px;padding:0 4px 14px;border-bottom:2px solid rgba(46,26,71,.12)}
    .stage-title h3{font:800 26px 'Baloo Bhaijaan 2';margin:0;color:var(--plum)}
    .stage-icon{display:grid;place-items:center;width:42px;height:42px;border-radius:12px;background:linear-gradient(135deg,#f6ebff,#fff7ef);box-shadow:inset 0 0 0 1px rgba(46,26,71,.06);font-size:24px}
    .stage-cards{display:grid;grid-template-columns:1fr 1.2fr;gap:22px;align-items:stretch}
    .stage-card{position:relative;overflow:hidden;background:linear-gradient(180deg,#fff 0%,#fffafc 100%);border:1.5px solid var(--line);border-radius:20px;padding:22px 18px 16px;box-shadow:0 14px 30px rgba(46,26,71,.08);transition:box-shadow .2s,transform .2s}
    .stage-card:hover{box-shadow:0 18px 36px rgba(46,26,71,.12);transform:translateY(-1px)}
    .stage-card::before{content:'';position:absolute;inset:0 0 auto 0;height:5px;background:linear-gradient(90deg,#2e1a47,#8a5fc9)}
    .stage-card--package::before{background:linear-gradient(90deg,#1e9b65,#6ad3a8)}
    .stage-card h4{position:relative;z-index:1;font:800 16px Tajawal;margin:0 0 16px;color:var(--plum);display:flex;align-items:center;gap:8px;letter-spacing:.2px}
    .stage-card h4::before{content:'';width:5px;height:20px;background:linear-gradient(135deg,#2e1a47,#8a5fc9);border-radius:3px}
    .stage-card--package h4::before{background:linear-gradient(135deg,var(--mint),#5cc99a)}

    .price-list{list-style:none;padding:0;margin:0;display:flex;flex-direction:column;gap:8px}
    .price-list li{display:flex;justify-content:space-between;align-items:center;gap:12px;background:linear-gradient(180deg,#f9f7ff,#f5f3fb);border:1px solid rgba(46,26,71,.06);border-radius:12px;padding:10px 12px}
    .price-list li .label{font-weight:700;color:var(--ink);font-size:13px}
    .price-list li .value{display:flex;flex-direction:column;align-items:flex-end;gap:4px;min-width:110px}
    .price-list li .value .line{display:inline-flex;align-items:center;justify-content:center;min-height:22px;padding:2px 8px;border-radius:8px;background:#fff;border:1px solid rgba(46,26,71,.08);color:var(--plum);font-weight:800;font-size:12px;line-height:1.3}
    .price-list li .value .line.secondary{color:var(--muted);background:#f8f3ff}
    .stage-card--package .price-list li{background:linear-gradient(180deg,#f8fff9,#f3fbf6)}
    .stage-card--package .price-list li .value{min-width:118px}
    .stage-card--package .price-list li .value .line{background:linear-gradient(180deg,#ebfff2,#eefbf2);color:var(--mint);border-color:rgba(30,155,101,.12)}
    .price-list li .old{color:var(--muted);text-decoration:line-through;font-size:12px;font-weight:600}
    .price-list li .new{color:var(--mint);font-weight:900;font-size:15px}

    .notice{max-width:840px;margin:10px auto 30px;padding:14px 18px;border:1px solid rgba(30,155,101,.18);background:linear-gradient(180deg,#f4fff8,#fff);border-radius:14px;text-align:center;color:var(--muted);font-size:12.5px;line-height:1.9}
    .cta{text-align:center;padding:30px 0 10px}
    .cta a{display:inline-block;background:linear-gradient(135deg,var(--coral),#ff8a68);color:#fff;font-weight:800;padding:15px 38px;border-radius:14px;text-decoration:none;box-shadow:0 16px 30px rgba(255,107,74,.32);transition:transform .15s}
    .cta a:hover{transform:translateY(-2px)}
    .cta small{display:block;margin-top:12px;color:var(--muted)}

    @media (max-width: 900px){.stage-cards{grid-template-columns:1fr}}
    @media (max-width: 560px){
      .stage-section{padding:18px 14px 16px}
      .stage-title{flex-direction:column;align-items:flex-start;gap:6px}
      .stage-title h3{font-size:21px}
      .stage-card{padding:16px 14px}
      .price-list li{padding:10px 10px}
      .price-list li .label{font-size:12px}
      .price-list li .value{min-width:74px;font-size:13px}
    }
  </style>
<style>
.topbar{position:sticky;top:0;z-index:50;background:#fffdfaf2;backdrop-filter:blur(12px);border-bottom:1px solid #ebdfeb}.nav{min-height:76px;display:flex;align-items:center;justify-content:space-between;gap:24px}.brand{display:flex;align-items:center;gap:12px;font-size:20px;font-weight:800}.brand img{width:48px;height:48px;border-radius:14px;object-fit:cover}.brand small{display:block;color:#71647d;font-size:10px;font-weight:500;margin-top:-3px}.links{display:flex;align-items:center;gap:26px}.links a{font-size:13px;font-weight:700;color:#594b64}.links a:hover,.links a.active{color:#f4674a}.actions{display:flex;gap:9px;align-items:center}.button{display:inline-block;border:0;border-radius:99px;padding:11px 19px;background:#f4674a;color:#fff;font:700 13px Cairo;cursor:pointer;transition:.2s}.button:hover{transform:translateY(-2px);background:#df4e33}.button.ghost{background:transparent;color:#241432}.menu-button{display:none;width:43px;height:43px;place-items:center;border:0;border-radius:12px;background:#21133d;color:#fff;font-size:24px;cursor:pointer}@media(max-width:760px){.nav{min-height:68px}.brand{font-size:16px}.links{display:none;position:absolute;top:68px;right:18px;left:18px;padding:10px;background:#fff;border:1px solid #ebdfeb;border-radius:18px;box-shadow:0 20px 35px #21133d24}.links.open{display:grid;gap:3px}.links a{padding:10px 12px;border-radius:9px}.links a:hover{background:#fff0e9}.actions{display:none}.menu-button{display:grid}}
</style></head>
<body>
@include('partials.site-nav')
<section class="hero">
  <div class="wrap">
    <span class="eyebrow">نتعلم اليوم... لنصنع غدًا أفضل</span>
    <h1>اختر السعر حسب منطقتك</h1>
    <p>نظام أسعار جديد يضم ثلاثة أقسام: غزة والضفة، مصر، وباقي الدول. اختر منطقتك للاطلاع على أسعار الحصة الفردية والباقات الموفّرة لكل مرحلة.</p>
  </div>
</section>
<main class="wrap">
  <div class="region-tabs" role="tablist" aria-label="مناطق الأسعار">
    <button type="button" class="active" data-region="gaza">🏔️ غزة والضفة</button>
    <button type="button" data-region="egypt">🇪🇬 مصر</button>
    <button type="button" data-region="world">🌍 باقي الدول</button>
  </div>

  <section class="pricing">
    @foreach ($regions as $key => $region)
      <div class="region <?= $key === 'gaza' ? 'active' : '' ?>" id="<?= $key ?>">
        <header class="region-heading">
          <h2><?= htmlspecialchars($region['title'], ENT_QUOTES, 'UTF-8') ?></h2>
          <p><?= htmlspecialchars($region['subtitle'], ENT_QUOTES, 'UTF-8') ?></p>
        </header>

        @foreach ($region['stages'] as $stage)
          <div class="stage-section">
            <div class="stage-title">
              <span class="stage-icon">📚</span>
              <h3><?= htmlspecialchars($stage['name'], ENT_QUOTES, 'UTF-8') ?></h3>
            </div>

            <div class="stage-cards">
              <div class="stage-card stage-card--single">
                <h4>الحصة الفردية</h4>
                <ul class="price-list">
                  @foreach ($stage['subjects'] as $subject)
                    <li>
                      <span class="label"><?= htmlspecialchars($subject['name'], ENT_QUOTES, 'UTF-8') ?></span>
                      <span class="value">
                        <span class="line secondary">شهري: <?= fmt($subject['monthly']) ?> <?= $region['currency'] ?></span>
                        <span class="line">فصلي: <?= fmt($subject['quarterly']) ?> <?= $region['currency'] ?></span>
                      </span>
                    </li>
                  @endforeach
                </ul>
              </div>

              <div class="stage-card stage-card--package">
                <h4>باقات المواد</h4>
                <ul class="price-list">
                  @foreach ($stage['bundles'] as $bundle)
                    <li>
                      <span class="label"><?= htmlspecialchars($bundle['name'], ENT_QUOTES, 'UTF-8') ?></span>
                      <span class="value">
                        <span class="old"><?= fmt($bundle['quarterly']) ?></span>
                        <span class="new"><?= fmt($bundle['discounted']) ?></span>
                        <?= $region['currency'] ?>
                      </span>
                    </li>
                  @endforeach
                </ul>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    @endforeach

    <div class="notice">تظهر الأسعار حسب المنطقة المختارة. يمكن تعديل الباقة تبعًا للمرحلة الدراسية وملف الطالب عند التسجيل.</div>
    <div class="cta">
      <a href="{{ route('register') }}">أنشئ حسابك واختر باقتك</a>
      <small>يمكنك التواصل معنا لمساعدة اختيار الباقة المناسبة.</small>
    </div>
  </section>
</main>
<script>
document.querySelectorAll('[data-region]').forEach(function(button){
  button.addEventListener('click', function(){
    document.querySelectorAll('[data-region]').forEach(function(item){
      item.classList.toggle('active', item === button);
    });
    document.querySelectorAll('.region').forEach(function(region){
      region.classList.toggle('active', region.id === button.dataset.region);
    });
  });
});
</script>
<script src="site-navigation.js?v=2"></script>
</body>
</html>


