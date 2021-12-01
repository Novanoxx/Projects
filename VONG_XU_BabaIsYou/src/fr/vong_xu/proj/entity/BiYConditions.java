package fr.vong_xu.proj.entity;

import java.util.List;
import java.util.Objects;

import fr.vong_xu.proj.readLevel.ReadLevel;

public class BiYConditions {
	/**
	 * Check in a list "list" if the block another is in another block
	 * 
	 * @param list the list used to compare
	 * @param another the block chosen to compare
	 * @return boolean
	 */
	public static boolean checkCondition(List<BiYBlock> list, BiYBlock another) {
		Objects.requireNonNull(list);
		for (BiYBlock block : list) {
			if (inAnother(block, another))
				return true;
		}
		return false;
	}
	
	/**
	 * Check if the block another is in a block in the list "sink_list"
	 * 
	 * @param sink_list the list of block which have sink at true
	 * @param another the block chosen to compare
	 * @return BiYBlock
	 */
	public static BiYBlock checkSink(List<BiYBlock> sink_list, BiYBlock another) {
		for (BiYBlock block : sink_list) {
			if (inAnother(block, another))
				return block;
		}
		return null;
	}
	
	/**
	 * Check if the block another is in a block in the list and if it is, there is the MELT/HOT reaction
	 * 
	 * @param list the list of block which have hot at true
	 * @param another the block chosen to compare
	 * @return boolean
	 */
	public static boolean checkHot(List<BiYBlock> list, BiYBlock another) {
		for (BiYBlock block : list) {
			if (inAnother(block, another) && (another.isMelt() && block.isHot()))
				return true;
		}
		return false;
	}
	
	/**
	 * Add to the remove_list all the block that need to be remove
	 * 
	 * @param block the block that will be add
	 * @param defeat_list the list of block having defeat at true
	 * @param sink_list the list of block having sink at true
	 * @param hot_list the list of block having hot at true
	 */
	public static void conditionsCheckers(BiYBlock block, List<BiYBlock> defeat_list, List<BiYBlock> sink_list, List<BiYBlock> hot_list) {
		BiYBlock tmp;
		if (!block.isDefeat() && BiYConditions.checkCondition(defeat_list, block) && block.isYou())
			ReadLevel.getRemove().add(block);
		
		tmp = BiYConditions.checkSink(sink_list, block);
		if (!block.isSink() && tmp != null) {
			ReadLevel.getRemove().add(tmp);
			ReadLevel.getRemove().add(block);
		}
		
		if (BiYConditions.checkHot(hot_list, block))
			ReadLevel.getRemove().add(block);
	}
	
	/** Function for avoiding an entity having the same x and y than an another entity(if there is a problem)
	 * 
	 * @param player the block n°1
	 * @param another the block n°2
	 * @return boolean
	 */
	public static boolean inAnother(BiYBlock player, BiYBlock another) {
		Objects.requireNonNull(player);
		Objects.requireNonNull(another);
		return player.getX() == another.getX() && player.getY() == another.getY();
	}
	/***********************************************************************/
}
