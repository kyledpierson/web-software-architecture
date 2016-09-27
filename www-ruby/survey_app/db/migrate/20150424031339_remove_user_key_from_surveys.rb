class RemoveUserKeyFromSurveys < ActiveRecord::Migration
  def up
    remove_column :surveys, :user_key
  end

  def down
    add_column :surveys, :user_key, :integer
  end
end
