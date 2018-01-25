<?php
namespace GestionnaireLivret\Domain;
class PresentationEc 
{
 private $id_presentation;
 private $fid_ec;
 private $objectifs;
 private $competences;
 private $prerequis;
 private $plan_cours;
 private $bibliographie;
 private $cours_en_ligne;
 private $modalite_controle;
 private $erasmus;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                
 function getId_presentation() {
     return $this->id_presentation;
 }
 function getFid_ec() {
     return $this->fid_ec;
 }
 function getObjectifs() {
     return $this->objectifs;
 }
 function getCompetences() {
     return $this->competences;
 }
 function getPrerequis() {
     return $this->prerequis;
 }
 function getPlan_cours() {
     return $this->plan_cours;
 }
 function getBibliographie() {
     return $this->bibliographie;
 }
 function getCours_en_ligne() {
     return $this->cours_en_ligne;
 }
 function getModalite_controle() {
     return $this->modalite_controle;
 }
 function getErasmus() {
     return $this->erasmus;
 }
 function setId_presentation($id_presentation) {
     $this->id_presentation = $id_presentation;
 }
 function setFid_ec($fid_ec) {
     $this->fid_ec = $fid_ec;
 }
 function setObjectifs($objectifs) {
     $this->objectifs = $objectifs;
 }
 function setCompetences($competences) {
     $this->competences = $competences;
 }
 function setPrerequis($prerequis) {
     $this->prerequis = $prerequis;
 }
 function setPlan_cours($plan_cours) {
     $this->plan_cours = $plan_cours;
 }
 function setBibliographie($bibliographie) {
     $this->bibliographie = $bibliographie;
 }
 function setCours_en_ligne($cours_en_ligne) {
     $this->cours_en_ligne = $cours_en_ligne;
 }
 function setModalite_controle($modalite_controle) {
     $this->modalite_controle = $modalite_controle;
 }
 function setErasmus($erasmus) {
     $this->erasmus = $erasmus;
 }
 
} 