<?php

use LiveVoting\Js\xlvoJs;
use LiveVoting\QuestionTypes\xlvoQuestionTypes;

/**
 * Class xlvoFreeOrderGUI
 *
 * @author            Fabian Schmid <fs@studer-raimann.ch>
 *
 * @ilCtrl_IsCalledBy xlvoFreeOrderGUI: xlvoVoter2GUI
 */
class xlvoFreeOrderGUI extends xlvoCorrectOrderGUI {

	/**
	 * xlvoFreeOrderGUI constructor.
	 */
	public function __construct() {
		parent::__construct();

		$this->setRandomizeOptions(false);
	}


	/**
	 * @return string
	 */
	public function getMobileHTML() {
		return $this->getFormContent() . xlvoJs::getInstance()->name(xlvoQuestionTypes::FREE_ORDER)->category('QuestionTypes')->getRunCode();
	}


	/**
	 * @param bool $current
	 */
	public function initJS($current = false) {
		xlvoJs::getInstance()->api($this)->name(xlvoQuestionTypes::FREE_ORDER)->category('QuestionTypes')
			->addLibToHeader('jquery.ui.touch-punch.min.js')->init();
	}


	/**
	 * @return array
	 */
	public function getButtonInstances() {
		if (!$this->manager->getPlayer()->isShowResults()) {
			return array();
		}
		$states = $this->getButtonsStates();
		$b = ilLinkButton::getInstance();
		$b->setId(self::BUTTON_TOTTLE_DISPLAY_CORRECT_ORDER);
		if ($states[self::BUTTON_TOTTLE_DISPLAY_CORRECT_ORDER]) {
			$b->setCaption(xlvoGlyphGUI::get('align-left'), false);
		} else {
			$b->setCaption(xlvoGlyphGUI::get('sort-by-attributes-alt'), false);
		}

		//		$t = ilLinkButton::getInstance();
		//		$t->setId(self::BUTTON_TOGGLE_PERCENTAGE);
		//		if ($states[self::BUTTON_TOGGLE_PERCENTAGE]) {
		//			$t->setCaption('%', false);
		//		} else {
		//			$t->setCaption(xlvoGlyphGUI::get('user'), false);
		//		}

		return array( $b );
	}


	/**
	 * @return bool
	 */
	protected function isShowCorrectOrder() {
		return false;
	}
}
