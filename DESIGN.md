---
name: SIMRS MiraCare Landing Page
description: Premium B2B SaaS landing page untuk Sistem Informasi Manajemen Rumah Sakit & Rekam Medis Elektronik (RME) terintegrasi.
colors:
  primary: "#0047AB"
  secondary: "#06B6D4"
  accent: "#0D9488"
  background-dark: "#0F172A"
  background-light: "#F8FAFC"
  surface: "#FFFFFF"
  text-primary: "#1E293B"
  text-secondary: "#64748B"
  text-inverse: "#FFFFFF"
typography:
  h1:
    fontFamily: "Plus Jakarta Sans, sans-serif"
    fontSize: "3rem"
    fontWeight: 700
    lineHeight: 1.2
  h2:
    fontFamily: "Plus Jakarta Sans, sans-serif"
    fontSize: "2rem"
    fontWeight: 700
    lineHeight: 1.3
  h3:
    fontFamily: "Plus Jakarta Sans, sans-serif"
    fontSize: "1.5rem"
    fontWeight: 600
    lineHeight: 1.4
  body-md:
    fontFamily: "Inter, sans-serif"
    fontSize: "1rem"
    fontWeight: 400
    lineHeight: 1.6
rounded:
  sm: "4px"
  md: "8px"
  lg: "16px"
  xl: "24px"
  full: "9999px"
spacing:
  sm: "8px"
  md: "16px"
  lg: "24px"
  xl: "32px"
  2xl: "64px"
  3xl: "120px"
components:
  button-primary:
    backgroundColor: "{colors.primary}"
    textColor: "{colors.text-inverse}"
    rounded: "{rounded.md}"
    padding: "12px 24px"
  pill-nav:
    backgroundColor: "transparent"
    borderColor: "rgba(255,255,255,0.2)"
    textColor: "{colors.text-inverse}"
    rounded: "{rounded.full}"
    padding: "8px 16px"
  image-container:
    backgroundColor: "{colors.surface}"
    rounded: "{rounded.xl}"
    padding: "0"
    overflow: "hidden"
---

## Overview
Desain difokuskan pada kejelasan informasi sistem SaaS (content-heavy) namun tetap terasa premium dan modern melalui penggunaan *whitespace* yang maksimal. Tonal kontras (navy gelap vs slate terang) dimanfaatkan sebagai pemisah *section* logis antara Modul, Fitur Utama, Demo Interaktif, dan Form Pendaftaran.

## Colors
Palet didominasi oleh warna biru medis tepercaya dan aksen toska/teal (trust blue, vibrant cyan, teal) yang terinspirasi dari logo baru **SIMRS MiraCare** untuk mengkomunikasikan keandalan teknologi (*trust*), kesehatan modern, dan kesesuaian B2B profesional.

## Typography
Menggunakan kombinasi font **Plus Jakarta Sans** untuk Heading memberikan kesan futuristik, kokoh, dan bersemangat, sedangkan **Inter** / **DM Sans** pada Body Text memastikan kenyamanan membaca deskripsi fitur medis yang kompleks tanpa kelelahan mata.

## Spacing & Layout
Menggunakan *12-column grid* pada desktop. Komposisi asimetris digunakan untuk memprioritaskan tangkapan layar/mockup dashboard portal (Admin, Dokter, Pasien) agar menjadi fokus perhatian utama pengunjung. *Padding* vertikal dijaga lapang (minimal 120px di desktop) untuk memberikan efek lega (*breathable space*).

## Rules to Never Break
- Jangan menggunakan *border* tegas untuk memisahkan *section* utama, gunakan kontras warna latar belakang (misalnya transisi antara `background-light` dan `surface`).
- Mockup dashboard/gambar produk wajib dibungkus dalam *container* bersudut membulat (`rounded.xl` / minimal 16px) dengan *box shadow* halus untuk kesan kedalaman (3D effect).
- Pastikan rasio kontras teks di atas area berwarna navy gelap (`background-dark`) memenuhi standar aksesibilitas tinggi (gunakan warna `#FFFFFF` atau `#F8FAFC`, hindari warna redup).