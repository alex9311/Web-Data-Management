
\version "2.16.2"
% automatically converted by musicxml2ly from scoretmp.xml

\header {
    encodingsoftware = "Finale 2011 for Windows"
    encodingdate = "2013-12-22"
    composer = "Gabriel Fauré (1845 - 1924)"
    title = "III.Sanctus"
    }

#(set-global-staff-size 18.313331811)
\paper {
    paper-width = 21.0\cm
    paper-height = 29.7\cm
    top-margin = 1.27\cm
    bottom-margin = 1.27\cm
    left-margin = 2.0\cm
    right-margin = 1.27\cm
    between-system-space = 1.35\cm
    page-top-space = 0.53\cm
    }
\layout {
    \context { \Score
        skipBars = ##t
        autoBeaming = ##f
        }
    }
PartPOneVoiceOne =  \relative bes' {
    \clef "treble" \key es \major \time 3/4 | % 1
    \tempo "" 4=60 R2.*2 | % 3
    bes2 ^\markup{ \bold {Andante moderato} } \pp ( c4 ~ | % 4
    c4 bes4 as4 ) | % 5
    bes4. r8 r4 | % 6
    R2. | % 7
    bes2 ( c4 ~ | % 8
    c4 bes4 as4 \break | % 9
    bes4. ) r8 r4 | \barNumberCheck #10
    R2. | % 11
    bes4 \p ( c4 des4 ~ | % 12
    des4 \> bes4 as4 ) | % 13
    bes4. \! r8 r4 | % 14
    R2. | % 15
    bes4 \p ( c4 ) des4 ~ | % 16
    des4 bes4 as4 \pageBreak | % 17
    bes4. r8 r4 | % 18
    R2. | % 19
    bes4 \p ( c4 ) d4 | \barNumberCheck #20
    f4. e8 d4 | % 21
    d2 ( c4 ) | % 22
    d2 ~ d8 r8 | % 23
    R2.*2 \break | % 25
    R2.*2 | % 27
    bes4 ^\markup{ \italic {sempre dolce} } ( bes4 es4 | % 28
    es4 d4 c4 | % 29
    bes2. | \barNumberCheck #30
    bes2. ) | % 31
    R2.*3 \break | % 34
    R2. | % 35
    bes4 ( c4 des4 | % 36
    f4. es8 ) des4 | % 37
    des2 ( c4 ) | % 38
    bes2. | % 39
    bes4 ^\markup{ \italic {poco a poco crescendo} } ( c4 d4 |
    \barNumberCheck #40
    es4 f4 ) g4 | % 41
    es2 ( d4 ) | % 42
    es2 \f r4 \pageBreak | % 43
    R2.*4 | % 47
    r2 \ff r8 es8 | % 48
    es2 ^> es4 | % 49
    as,4 ( bes4 ) c4 | \barNumberCheck #50
    es2 ^\markup{ \italic {dim.} } es4 \break | % 51
    as,4 ( bes4 ) c4 | % 52
    es2. \p | % 53
    es2 \pp r4 | % 54
    g,2. \pp | % 55
    g2. ~ | % 56
    g2. | % 57
    R2.*6 \bar "|."
    }

PartPOneVoiceOneLyricsOne =  \lyricmode { Sanc -- "tus," Sanc -- Do --
    "us," De -- "us " __ Sa -- ba -- "oth." Sanc -- "tus," Do -- mi --
    nus De -- "us. " __ Ple -- Ho -- ex -- cel -- "sis." Ho -- ex -- cel
    -- "sis." Ho -- san -- na "in " __ ex -- cel -- "sis," "in " __ ex
    -- cel -- "sis." Sanc -- "tus. " __ }
PartPTwoVoiceOne =  \relative es' {
    \clef "treble" \key es \major \time 3/4 R2.*8 \break | % 9
    R2.*2 | % 11
    R2.*5 | % 16
    R2. \pageBreak | % 17
    R2.*3 | \barNumberCheck #20
    R2.*5 \break | % 25
    R2.*9 \break | % 34
    R2.*9 \pageBreak | % 43
    R2.*8 \break | % 51
    R2.*3 | % 54
    es2. \< \! \< \! \> \! \< \! \> \! \pp | % 55
    es2. ~ | % 56
    es2. | % 57
    R2.*6 \bar "|."
    }

PartPTwoVoiceOneLyricsOne =  \lyricmode { Sanc -- "tus. " __ }
PartPThreeVoiceOne =  \relative bes {
    \clef "treble_8" \key es \major \time 3/4 | % 1
    R2.*4 | % 5
    bes2 ^\markup{ \italic {tenore & basso unisone} } \pp ( c4 ~ | % 6
    c4 bes4 as4 ) | % 7
    bes4. r8 r4 | % 8
    R2. \break | % 9
    bes2 \pp ( c4 ~ | \barNumberCheck #10
    c4 bes4 as4 | % 11
    bes4. ) r8 r4 | % 12
    R2. | % 13
    bes4 \p ( c4 d4 ~ | % 14
    d4 bes4 as4 ) | % 15
    bes4. r8 r4 | % 16
    R2. \pageBreak | % 17
    bes4 \pp \< ( c4 ) d4 ~ | % 18
    d4 \! \> bes4 as4 | % 19
    bes4. \! r8 r4 | \barNumberCheck #20
    R2.*3 | % 23
    a2 ( b4 ~ | % 24
    b4 a4 g4 \break | % 25
    a2 ~ a8 [ a8 ] | % 26
    bes2. ) | % 27
    R2.*4 | % 31
    bes4. ^\markup{ \italic {sempre dolce} } ( bes8 es4 | % 32
    es4 d4 c4 | % 33
    bes2. \break | % 34
    bes2. ) | % 35
    R2.*8 \pageBreak | % 43
    r4 \ff r4 r8 es8 | % 44
    es2 ^> es4 | % 45
    as,4 ( bes4 ) c4 | % 46
    es2 es4 | % 47
    as,4 ^\markup{ \italic {sempre} } \ff ( bes4 ) c4 | % 48
    es2. | % 49
    es4. r8 r4 | \barNumberCheck #50
    R2. \break | % 51
    R2.*2 | % 53
    bes2. \pp ^\markup{ \italic {divisi} } ~ | % 54
    bes2. | % 55
    bes2. ~ | % 56
    bes2. | % 57
    R2.*6 \bar "|."
    }

PartPThreeVoiceOneLyricsOne =  \lyricmode { Sanc -- "tus," Sanc -- Do --
    "us," De -- "us " __ Sa -- ba -- "oth." De -- Glo -- Ho -- san -- na
    in -- ex -- cel -- "sis," in -- ex -- cel -- "sis." Sanc -- "tus. "
    __ }
PartPThreeVoiceTwo =  \relative g {
    \clef "treble_8" \key es \major \time 3/4 | % 1
    s1*3 ^\markup{ \italic {tenore & basso unisone} } | % 5
    s1*3 \pp \break | % 9
    s1*3 \pp | % 13
    s1*3 \p \pageBreak | % 17
    s2. \pp \< | % 18
    s2. \! \> s2*9 \! \break s2*9 | % 31
    s4*9 ^\markup{ \italic {sempre dolce} } \break s4*27 \pageBreak | % 43
    s1*3 \ff | % 47
    s1*3 ^\markup{ \italic {sempre} } \ff \break s1. | % 53
    g2. \pp ^\markup{ \italic {divisi} } ~ | % 54
    g2. | % 55
    g2. ~ | % 56
    g2. s2*9 \bar "|."
    }

PartPThreeVoiceTwoLyricsOne =  \lyricmode { Sanc -- "tus. " __ }
PartPFourVoiceOne =  \relative bes {
    \clef "bass" \key es \major \time 3/4 R2.*4 | % 5
    bes2 \pp ( c4 ~ | % 6
    c4 bes4 as4 ) | % 7
    bes4. r8 r4 | % 8
    R2. \break | % 9
    bes2 \pp ( c4 ~ | \barNumberCheck #10
    c4 bes4 as4 | % 11
    bes4. ) r8 r4 | % 12
    R2. | % 13
    bes4 \p \< \< ( c4 d4 ~ | % 14
    d4 \! \! \> bes4 \> as4 ) | % 15
    bes4. \! r8 \! r4 | % 16
    R2. \pageBreak | % 17
    bes4 \pp \< ( c4 ) d4 ~ | % 18
    d4 \! \> bes4 as4 | % 19
    bes4. \! r8 r4 | \barNumberCheck #20
    R2.*3 | % 23
    a2 ( b4 ~ | % 24
    b4 a4 g4 \break | % 25
    a2 ~ a8 [ a8 ] | % 26
    bes2. ) | % 27
    R2.*4 | % 31
    bes4. ^\markup{ \italic {sempre dolce} } ( bes8 es4 | % 32
    es4 d4 c4 | % 33
    bes2. \break | % 34
    bes2. ) | % 35
    R2.*8 \pageBreak | % 43
    r4 \ff r4 r8 es8 | % 44
    es2 ^> es4 | % 45
    as,4 ( bes4 ) c4 | % 46
    es2 es4 | % 47
    as,4 ^\markup{ \italic {sempre} } \ff ( bes4 ) c4 | % 48
    es2. | % 49
    es4. r8 r4 | \barNumberCheck #50
    R2. \break | % 51
    R2.*2 | % 53
    es,2. \pp ^\markup{ \italic {divisi} } ~ | % 54
    es2. | % 55
    es2. ~ | % 56
    es2. | % 57
    R2.*6 \bar "|."
    }

PartPFourVoiceOneLyricsOne =  \lyricmode { Sanc -- "tus," Sanc -- Do --
    "us," De -- "us " __ Sa -- ba -- "oth." De -- Glo -- Ho -- san -- na
    in -- ex -- cel -- "sis," in -- ex -- cel -- "sis." Sanc -- "tus. "
    __ }
PartPFourVoiceTwo =  \relative bes, {
    \clef "bass" \key es \major \time 3/4 s1*3 | % 5
    s1*3 \pp \break | % 9
    s1*3 \pp | % 13
    s2. \p \< \< | % 14
    s4 \! \! \> s2 \> | % 15
    s4. \! s8*9 \! \pageBreak | % 17
    s2. \pp \< | % 18
    s2. \! \> s2*9 \! \break s2*9 | % 31
    s4*9 ^\markup{ \italic {sempre dolce} } \break s4*27 \pageBreak | % 43
    s1*3 \ff | % 47
    s1*3 ^\markup{ \italic {sempre} } \ff \break s1. | % 53
    bes2. \pp ^\markup{ \italic {divisi} } ~ | % 54
    bes2. | % 55
    bes2. ~ | % 56
    bes2. s2*9 \bar "|."
    }

PartPFourVoiceTwoLyricsOne =  \lyricmode { Sanc -- "tus. " __ }

% The score definition
\score {
    <<
        \new StaffGroup \with { \override SpanBar #'transparent = ##t }
        <<
            \new Staff <<
                \set Staff.instrumentName = "Soprano"
                \set Staff.shortInstrumentName = "S"
                \context Staff << 
                    \context Voice = "PartPOneVoiceOne" { \PartPOneVoiceOne }
                    \new Lyrics \lyricsto "PartPOneVoiceOne" \PartPOneVoiceOneLyricsOne
                    >>
                >>
            \new Staff <<
                \set Staff.instrumentName = "Alto"
                \set Staff.shortInstrumentName = "A"
                \context Staff << 
                    \context Voice = "PartPTwoVoiceOne" { \PartPTwoVoiceOne }
                    \new Lyrics \lyricsto "PartPTwoVoiceOne" \PartPTwoVoiceOneLyricsOne
                    >>
                >>
            \new Staff <<
                \set Staff.instrumentName = "Tenore"
                \set Staff.shortInstrumentName = "T"
                \context Staff << 
                    \context Voice = "PartPThreeVoiceOne" { \voiceOne \PartPThreeVoiceOne }
                    \new Lyrics \lyricsto "PartPThreeVoiceOne" \PartPThreeVoiceOneLyricsOne
                    \context Voice = "PartPThreeVoiceTwo" { \voiceTwo \PartPThreeVoiceTwo }
                    \new Lyrics \lyricsto "PartPThreeVoiceTwo" \PartPThreeVoiceTwoLyricsOne
                    >>
                >>
            \new Staff <<
                \set Staff.instrumentName = "Basso"
                \set Staff.shortInstrumentName = "B"
                \context Staff << 
                    \context Voice = "PartPFourVoiceOne" { \voiceOne \PartPFourVoiceOne }
                    \new Lyrics \lyricsto "PartPFourVoiceOne" \PartPFourVoiceOneLyricsOne
                    \context Voice = "PartPFourVoiceTwo" { \voiceTwo \PartPFourVoiceTwo }
                    \new Lyrics \lyricsto "PartPFourVoiceTwo" \PartPFourVoiceTwoLyricsOne
                    >>
                >>
            
            >>
        
        >>
    \layout {}
    % To create MIDI output, uncomment the following line:
    %  \midi {}
    }

